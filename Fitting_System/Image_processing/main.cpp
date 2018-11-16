#include <my_global.h>
#include <winsock2.h>
#include <mysql.h>

#include <iostream>
#include <string>
#include <stdio.h>
#include <time.h>

#include<opencv2/core.hpp>
#include <opencv2/core/core.hpp>
#include<opencv2/imgproc.hpp>
#include "opencv2/imgcodecs.hpp"
#include<opencv2/highgui.hpp>
#include "opencv2/opencv.hpp"
#include <opencv2/objdetect/objdetect.hpp>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>

using namespace std;
using namespace cv;

String eye_cascade = "c:/opencv/sources/data/haarcascades/haarcascade_eye.xml";
CascadeClassifier eye;

double userReal_height = 0;  // user's real height
double user_eyePointY = 0;   // user's eye hight

std::string user_id;      // current login user
std::string user_gender;  // user's gender

#pragma comment(lib, "libmysql.lib")

// get current date
const std::string currentDateTime() {
	time_t     now = time(0); // current time
	struct tm  tstruct;
	char       buf[80];

	localtime_s(&tstruct, &now);
	strftime(buf, sizeof(buf), "%Y-%m-%d %X", &tstruct); // YYYY-MM-DD HH:mm:ss

	return buf;
}

void main() {

	//Mysql - get user info
	MYSQL *connection = NULL, conn;
	MYSQL_RES *sql_result;
	MYSQL_ROW sql_row;

	int query_stat, num_fields;
	std::string sql_query;

	mysql_init(&conn);

	connection = mysql_real_connect(&conn, "localhost", "root", "", "seeyou", 3306, NULL, 0);
	if (connection == NULL) {
		fprintf(stderr, "Mysql connection error : %s", mysql_error(&conn));
	}

	// find current login user's ID
	query_stat = mysql_query(connection, "select user_id from current_login_user");
	if (query_stat != 0) {
		fprintf(stderr, "Mysql connection error : %s", mysql_error(&conn));
	}

	// store result
	sql_result = mysql_store_result(&conn);
	num_fields = mysql_num_fields(sql_result);
	sql_row = mysql_fetch_row(sql_result);
	user_id = sql_row[0];


	// find user's gender
	sql_query = "select gender from user_info where user_id='";
	sql_query += user_id;
	sql_query += "'";

	query_stat = mysql_query(connection, sql_query.c_str());
	if (query_stat != 0) {
		fprintf(stderr, "Mysql connection error : %s", mysql_error(&conn));
	}

	// store result
	sql_result = mysql_store_result(&conn);
	num_fields = mysql_num_fields(sql_result);
	sql_row = mysql_fetch_row(sql_result);
	user_gender = sql_row[0];

	std::cout << "user ID :" << user_id << std::endl;
	std::cout << "user gender :" << user_gender << std::endl;

	// get user height
	std::cout << "Input your height (cm) : ";
	std::cin >> userReal_height;
	userReal_height *= 10; // 'mm' value

	// open image grayscale - original
	Mat dst1 = imread("A.jpg");   // front image
	Mat dst2 = imread("B.jpg");   // side image

// image reduction (480x890)
	Mat img1, img2;
	resize(dst1, img1, Size(dst1.cols / 7, dst1.rows / 7), 0, 0, CV_INTER_LINEAR);
	resize(dst2, img2, Size(dst2.cols / 7, dst2.rows / 7), 0, 0, CV_INTER_LINEAR);


// delete background
	Rect rectangle1(20, 20, dst1.cols / 7 - 40, dst1.rows / 7 - 40); // grab range
	Rect rectangle2(80, 20, dst1.cols / 7 - 160, dst1.rows / 7 - 40); // grab range
	Mat Bresult1, Bresult2; // segmentation
	Mat bgModel1, fgModel1, bgModel2, fgModel2; 

	// grabcut(input image, segmentation result, rectangle withforeground, model, model, loop count, use rectangle)
	grabCut(img1, Bresult1, rectangle1, bgModel1, fgModel1, 5, GC_INIT_WITH_RECT);
	compare(Bresult1, GC_PR_FGD, Bresult1, CMP_EQ);
	Mat foreground1(img1.size(), CV_8UC3, Scalar(255, 255, 255));
	img1.copyTo(foreground1, Bresult1); // create result image

	grabCut(img2, Bresult2, rectangle2, bgModel2, fgModel2, 5, GC_INIT_WITH_RECT);
	compare(Bresult2, GC_PR_FGD, Bresult2, CMP_EQ);
	Mat foreground2(img2.size(), CV_8UC3, Scalar(255, 255, 255));
	img2.copyTo(foreground2, Bresult2); // create result image

	imwrite("A1.jpg", foreground1);
	imwrite("B1.jpg", foreground2);	

// extract image outline
	int y, x, r, c, sumX = 0, sumY = 0, sum = 0;
	img1 = imread("A1.jpg", 0);   // front image
	img2 = imread("B1.jpg", 0);   // side image

	Mat result_img1(img1.rows, img1.cols, CV_8UC1);  // front
	Mat result_img2(img2.rows, img2.cols, CV_8UC1);  // side

	// sobel mask values
	int maskX[3][3] = { { -1, 0, 1 },
	{ -2, 0, 2 },
	{ -1, 0, 1 } };

	int maskY[3][3] = { { -1, -2, -1 },
	{ 0, 0, 0 },
	{ 1, 2, 1 } };

	// convolution - front image
	for (y = 0; y<img1.rows - 2; y++) {
		for (x = 0; x<img1.cols - 2; x++) {
			for (r = 0; r<3; r++) {
				for (c = 0; c<3; c++) {
					sumX += img1.at<uchar>(y + r, x + c) * maskX[r][c];
					sumY += img1.at<uchar>(y + r, x + c) * maskY[r][c];
				}
			}
			sum = abs(sumX) + abs(sumY);
			if (sum > 255) sum = 255;
			else if (sum < 0) sum = 0;

			result_img1.at<uchar>(y + 1, x + 1) = sum;
			sum = 0;
			sumX = 0;
			sumY = 0;
		}
	}

	sumX = 0, sumY = 0, sum = 0;
	// convolution - side image
	for (y = 0; y<img2.rows - 2; y++) {
		for (x = 0; x<img2.cols - 2; x++) {
			for (r = 0; r<3; r++) {
				for (c = 0; c<3; c++) {
					sumX += img2.at<uchar>(y + r, x + c) * maskX[r][c];
					sumY += img2.at<uchar>(y + r, x + c) * maskY[r][c];
				}
			}
			sum = abs(sumX) + abs(sumY);
			if (sum > 255) sum = 255;
			else if (sum < 0) sum = 0;

			result_img2.at<uchar>(y + 1, x + 1) = sum;
			sum = 0;
			sumX = 0;
			sumY = 0;
		}
	}

	imwrite("sobelA.jpg", result_img1); // sobel result image - front
	imwrite("sobelB.jpg", result_img2); // sobel result image - side


// cut image to find user's height
	Mat Simg1 = imread("sobelA.jpg", 0); // open image grayscale - front
	Mat Simg2 = imread("sobelB.jpg", 0); // open image grayscale - side
	int startY1 = 0, endY1 = 0; // top, bottom Y value

	// front
	// top value
	for (y = 5; y<Simg1.rows; y++) {
		for (x = 5; x < Simg1.cols - 5; x++) {
			if (Simg1.at<uchar>(y, x) > 200) {
				if (startY1 == 0) {
					startY1 = y;
					break;
				}
			}
		}
	}

	// bottom value
	for (y = Simg1.rows - 6; y>4; y--) {
		for (x = 5; x < Simg1.cols - 5; x++) {
			if (Simg1.at<uchar>(y, x) > 200) {
				if (endY1 == 0) {
					endY1 = y;
					break;
				}
			}
		}
	}

	Rect rect1(5, startY1, Simg1.cols - 10, endY1 - startY1);
	Mat result_cut1 = Simg1(rect1);
	imwrite("cutA.jpg", result_cut1); // cut image depend on the user height - front

	// update foreground front image due to find eyes
	Mat original = foreground1(rect1);
	imwrite("A1.jpg", original);


	// side
	int startY2 = 0, endY2 = 0; // top, bottom Y value
	// top value
	for (y = 5; y<Simg2.rows; y++) {
		for (x = 5; x < Simg2.cols - 5; x++) {
			if (Simg2.at<uchar>(y, x) > 200) {
				if (startY2 == 0) {
					startY2 = y;
					break;
				}
			}
		}
	}

	// bottom value
	for (y = Simg2.rows - 6; y>4; y--) {
		for (x = 5; x < Simg2.cols - 5; x++) {
			if (Simg2.at<uchar>(y, x) > 200) {
				if (endY2 == 0) {
					endY2 = y;
					break;
				}
			}
		}
	}

	Rect rect2(5, startY2, Simg2.cols - 10, endY2 - startY2);
	Mat result_cut2 = Simg2(rect2);
	imwrite("cutB.jpg", result_cut2); // cut image depend on the user height - side

// resize the image - front, side
	Mat Rimg, temp;

	if (result_cut2.rows > result_cut1.rows) {
		resize(result_cut2, Rimg, Size(result_cut1.rows * result_cut1.cols / result_cut2.rows, result_cut1.rows), 0, 0, CV_INTER_LINEAR);
		imwrite("cutB.jpg", Rimg);
	}
	else if(result_cut2.rows < result_cut1.rows){
		resize(result_cut1, Rimg, Size(result_cut2.rows * result_cut2.cols / result_cut1.rows, result_cut1.rows), 0, 0, CV_INTER_LINEAR);
		imwrite("cutA.jpg", Rimg);

		// update foreground image size
		resize(original, temp, Size(original.cols, original.rows), 0, 0, CV_INTER_LINEAR);
		imwrite("A1.jpg", temp);
	}


// calculate user height - side
	double userPixel_height = endY1 - startY1; // user height (pixel value)
	double onePixelvalue = userReal_height / userPixel_height; // one pixel = result 'mm'


// find eyes
	original = imread("A1.jpg"); // foreground image
	assert(original.data);

	bool b = eye.load(eye_cascade);
	assert(b);

	Mat gray;
	cvtColor(original, gray, CV_BGR2GRAY); // use original image

	std::vector<Rect> eye_pos;
	eye.detectMultiScale(gray, eye_pos, 1.1, 2, 0 | CV_HAAR_SCALE_IMAGE, Size(10, 10));

	for (int i = 0; i < eye_pos.size(); i++) {
		Point center(eye_pos[i].x + eye_pos[i].width*0.5, eye_pos[i].y + eye_pos[i].height*0.5);
		user_eyePointY += eye_pos[i].y + eye_pos[i].height*0.5;
	}
	user_eyePointY /= 2;   // both eyes's medium value

	double eyes = 0;
	eyes = userPixel_height / user_eyePointY;	// head rate

// calculate each body rate
	int shoulderY = 0, chestY = 0, waistY = 0, hipY = 0, thighY = 0;  // Y value

	if (user_gender == "male") {
		if (eyes < 12) {
			shoulderY = userPixel_height * 0.19;
			chestY = userPixel_height * 0.27;
			waistY = userPixel_height * 0.46;
			hipY = userPixel_height * 0.51;
			thighY = userPixel_height * 0.6;
		}
		else if (eyes == 12) {
			shoulderY = userPixel_height * 0.2;
			chestY = userPixel_height * 0.26;
			waistY = userPixel_height * 0.46;
			hipY = userPixel_height * 0.51;
			thighY = userPixel_height * 0.6;
		}
		else if (eyes <= 15 && eyes > 12) {
			shoulderY = userPixel_height * 0.19;
			chestY = userPixel_height * 0.26;
			waistY = userPixel_height * 0.46;
			hipY = userPixel_height * 0.51;
			thighY = userPixel_height * 0.6;
		}
		else if (eyes == 16) {
			shoulderY = userPixel_height * 0.19;
			chestY = userPixel_height * 0.26;
			waistY = userPixel_height * 0.46;
			hipY = userPixel_height * 0.5;
			thighY = userPixel_height * 0.6;
		}
		else if (eyes >= 17) {
			shoulderY = userPixel_height * 0.18;
			chestY = userPixel_height * 0.26;
			waistY = userPixel_height * 0.45;
			hipY = userPixel_height * 0.51;
			thighY = userPixel_height * 0.6;
		}
	}
	else if (user_gender == "female") {
		if (eyes < 12) {
			shoulderY = userPixel_height * 0.2;
			chestY = userPixel_height * 0.26;
			waistY = userPixel_height * 0.46;
			hipY = userPixel_height * 0.52;
			thighY = userPixel_height * 0.6;
		}
		else if (eyes == 12) {
			shoulderY = userPixel_height * 0.19;
			chestY = userPixel_height * 0.26;
			waistY = userPixel_height * 0.46;
			hipY = userPixel_height * 0.51;
			thighY = userPixel_height * 0.6;
		}
		else if (eyes > 12) {
			shoulderY = userPixel_height * 0.19;
			chestY = userPixel_height * 0.26;
			waistY = userPixel_height * 0.46;
			hipY = userPixel_height * 0.51;
			thighY = userPixel_height * 0.6;
		}
	}

	Mat front = imread("cutA.jpg", 0);
	Mat side = imread("cutB.jpg", 0);



// find shoulder
	int left_shoulder = 0, right_shoulder = 0;

	for (x = 0; x < front.cols; x++) {
		if (front.at<uchar>(shoulderY, x) > 100) {
			left_shoulder = x;
			break;
		}
	}

	for (x = front.cols - 1; x > 0; x--) {
		if (front.at<uchar>(shoulderY, x) > 100) {
			right_shoulder = x;
			break;
		}
	}

	int shoulder = 0;
	shoulder = right_shoulder - left_shoulder; // shoulder pixel
	double RealShoulder = shoulder * onePixelvalue / 10;  // real shoulder value 'cm'

// cut budy image
	Rect Brect(left_shoulder, 0, shoulder, front.rows - 1);
	Mat body_cut = front(Brect);
	imwrite("bodyA.jpg", body_cut);		// only body image
	body_cut = imread("bodyA.jpg", 0);


// find waist
	int waist1 = 0, waist2 = 0;
	int left_waist1 = 0, right_waist1 = 0, left_waist2 = 0, right_waist2 = 0;

	for (x = 0; x < body_cut.cols; x++) {
		if (body_cut.at<uchar>(waistY, x) > 100) {
			left_waist1 = x;
			break;
		}
	}

	for (x = body_cut.cols - 1; x > 0; x--) {
		if (body_cut.at<uchar>(waistY, x) > 100) {
			right_waist1 = x;
			break;
		}
	}

	waist1 = right_waist1 - left_waist1;  // front value
	waist1 /= 2;

	for (x = 0; x < side.cols; x++) {
		if (side.at<uchar>(waistY, x) > 100) {
			left_waist2 = x;
			break;
		}
	}

	for (x = side.cols - 1; x > 0; x--) {
		if (side.at<uchar>(waistY, x) > 100) {
			right_waist2 = x;
			break;
		}
	}

	waist2 = right_waist2 - left_waist2;  // side value
	waist2 /= 2;

	int Wsum = waist1 + waist2;
	int Wmul = waist1 * waist2;
	double Wtemp = 3.14 * ((5 * Wsum / 4) - Wmul / Wsum);
	double RealWaist = Wtemp * onePixelvalue / 10;  // 'cm' value


// find chest
	int chest1 = 0, chest2 = 0;
	int left_chest = 0, right_chest = 0;

	for (x = 0; x < side.cols; x++) {
		if (side.at<uchar>(chestY, x) > 100) {
			left_chest = x;
			break;
		}
	}

	for (x = side.cols - 1; x > 0; x--) {
		if (side.at<uchar>(chestY, x) > 100) {
			right_chest = x;
			break;
		}
	}

	chest1 = right_chest - left_chest;  // side value
	chest1 /= 2;
	chest2 = waist1;  // front value

	int Csum = chest1 + chest2;
	int Cmul = chest1 * chest2;
	double Ctemp = 3.14 * ((5 * Csum / 4) - Cmul / Csum);
	double RealChest = Ctemp * onePixelvalue / 10;
 

// find hip
	int hip1 = 0, hip2 = 0;
	int left_hip1 = 0, right_hip1 = 0, left_hip2 = 0, right_hip2 = 0;

	for (x = 0; x < body_cut.cols; x++) {
		if (body_cut.at<uchar>(hipY, x) > 100) {
			left_hip1 = x;
			break;
		}
	}

	for (x = body_cut.cols - 1; x > 0; x--) {
		if (body_cut.at<uchar>(hipY, x) > 100) {
			right_hip1 = x;
			break;
		}
	}

	hip1 = right_hip1 - left_hip1;  // front value
	hip1 /= 2;

	for (x = 0; x < side.cols; x++) {
		if (side.at<uchar>(hipY, x) > 100) {
			left_hip2 = x;
			break;
		}
	}

	for (x = side.cols - 1; x > 0; x--) {
		if (side.at<uchar>(hipY, x) > 100) {
			right_hip2 = x;
			break;
		}
	}

	hip2 = right_hip2 - left_hip2;  // side value
	hip2 /= 2;

	int Hsum = hip1 + hip2;
	int Hmul = hip1 * hip2;
	double Htemp = 3.14 * ((5 * Hsum / 4) - Hmul / Hsum);
	double RealHip = Htemp * onePixelvalue / 10;


// find thight
	int thigh1 = 0, thigh2 = 0;
	int left_thigh1 = 0, right_thigh1 = 0, left_thigh2 = 0, right_thigh2 = 0;

	for (x = 0; x < body_cut.cols; x++) {
		if (body_cut.at<uchar>(thighY, x) > 100) {
			left_thigh1 = x;
			break;
		}
	}

	for (x = body_cut.cols - 1; x > 0; x--) {
		if (body_cut.at<uchar>(thighY, x) > 100) {
			right_thigh1 = x;
			break;
		}
	}

	thigh1 = (right_thigh1 - left_thigh1) / 2;  // front value
	thigh1 /= 2;

	for (x = 0; x < side.cols; x++) {
		if (side.at<uchar>(thighY, x) > 100) {
			left_thigh2 = x;
			break;
		}
	}

	for (x = side.cols - 1; x > 0; x--) {
		if (side.at<uchar>(thighY, x) > 100) {
			right_thigh2 = x;
			break;
		}
	}

	thigh2 = right_thigh2 - left_thigh2;  // side value
	thigh2 /= 2;

	int Tsum = thigh1 + thigh2;
	int Tmul = thigh1 * thigh2;
	double Ttemp = 3.14 * ((5 * Tsum / 4) - Tmul / Tsum);
	double RealThigh = Ttemp * onePixelvalue / 10;

// cut arm image
	Rect Arect(0, shoulderY, left_shoulder, front.rows - 1 - shoulderY - (front.rows-1 - thighY));
	Mat arm_cut = front(Arect);
	imwrite("armA.jpg", arm_cut);
	arm_cut = imread("armA.jpg", 0);

// arm length
	int armPointY = 0, armPointX = 0;

	for (y = 0; y < arm_cut.rows; y++) {
		for (x = 0; x < arm_cut.cols; x++) {
			if (arm_cut.at<uchar>(y, x) > 100) {
				armPointY = y;
				armPointX = x;
				break;
			}
		}
	}

	double arm = 0;
	int aX = arm_cut.cols - armPointX - 1;
	double R = aX * aX + armPointY * armPointY;
	arm = sqrt(R);
	double RealArm = arm * onePixelvalue / 10;

// leg length
	int leg = front.rows - 1 - waistY;
	double RealLeg = leg * onePixelvalue / 10;


	// show result
	line(front, Point(left_shoulder, shoulderY), Point(right_shoulder, shoulderY), Scalar(255, 255, 0), 2);
	line(body_cut, Point(left_waist1, waistY), Point(right_waist1, waistY), Scalar(255, 255, 0), 2);
	line(body_cut, Point(left_hip1, hipY), Point(right_hip1, hipY), Scalar(255, 255, 0), 2);
	line(body_cut, Point(left_thigh1, thighY), Point(right_thigh1, thighY), Scalar(255, 255, 0), 2);
	line(front, Point(10, waistY), Point(10, endY1), Scalar(255, 255, 0), 2);

	line(arm_cut, Point(armPointX, armPointY), Point(arm_cut.cols - 1, 0), Scalar(255, 255, 0), 2);
	line(side, Point(left_chest, chestY), Point(right_chest, chestY), Scalar(255, 255, 0), 2);
	line(side, Point(left_waist2, waistY), Point(right_waist2, waistY), Scalar(255, 255, 0), 2);
	line(side, Point(left_hip2, hipY), Point(right_hip2, hipY), Scalar(255, 255, 0), 2);
	line(side, Point(left_thigh2, thighY), Point(right_thigh2, thighY), Scalar(255, 255, 0), 2);

	imshow("front", front);
	imshow("side", side);
	imshow("body cut", body_cut);
	imshow("arm cut", arm_cut);

// store each body value to DB
	std::string S = std::to_string((int)RealShoulder);
	std::string C = std::to_string((int)RealChest);
	std::string A = std::to_string((int)RealArm);
	std::string W = std::to_string((int)RealWaist);
	std::string H = std::to_string((int)RealHip);
	std::string T = std::to_string((int)RealThigh);
	std::string L = std::to_string((int)RealLeg);
	std::string HI = std::to_string((int)userReal_height / 10);

	sql_query = "insert into body_value (user_id, shoulder, chest, arm, waist, hip, thigh, leg, hight, date_info) VALUES ('";
	sql_query += user_id;
	sql_query += "',";
	sql_query += S;
	sql_query += ",";
	sql_query += C;
	sql_query += ",";
	sql_query += A;
	sql_query += ",";
	sql_query += W;
	sql_query += ",";
	sql_query += H;
	sql_query += ",";
	sql_query += T;
	sql_query += ",";
	sql_query += L;
	sql_query += ",";
	sql_query += HI;
	sql_query += ",'";
	sql_query += currentDateTime();
	sql_query += "')";

	query_stat = mysql_query(connection, sql_query.c_str());
	if (query_stat != 0) {
		fprintf(stderr, "Mysql connection error : %s", mysql_error(&conn));
	}

	mysql_free_result(sql_result);
	mysql_close(connection);
	waitKey(0);
}
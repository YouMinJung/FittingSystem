# < FittingSystem > Capston Design 2 - 2017.12

<p> Environment : Sublime Text, Visual Studio 2017, PyCharm, Jupyter Notebook in Windows,
<p> Language : C/C++, PHP, Java-Script, Python

<br><br>

<p> 머신 러닝을 이용하여 이미지를 통해 사용자의 신체 정보를 추출하는 자동 피팅 시스템 </p>
<p> 웹 또는 앱을 이용하여 사용자가 자신의 정면 전신 이미지와 측면 전신 이미지 그리고 키 정보를 입력한다. 이 데이터를 이용해 사용자의 신체 치수 정보를 추출한다. 추출 시에는 미리 객체 추출, 신체 부위 인식 등을 학습한 데이터를 이용한다. 추출된 신체 정보를 바탕으로 사용자가 구입하고자 하는 의류와 매칭하여 가상 피팅된 결과를 시각적으로 제공한다.</p>

<br><br>

#### Joomla를 이용한 Web Page 및 Menu 구성
![default](https://user-images.githubusercontent.com/21214309/48612944-b9d34b80-e9cd-11e8-95fd-43d0b72b4bcb.JPG)

- 기본적으로 동작하는 바탕인 웹페이지를 제작

<br><br>

#### Database Structure
![default](https://user-images.githubusercontent.com/21214309/48612806-5812e180-e9cd-11e8-9f36-8fdff8ce9530.JPG)

- 사용자 INFO : User_info, Bidy_value Table
- Login : Current_login_user Table
- Cloth INFO : Cloth_info1, Cloth_info2 Table

<br><br>

#### Image Processing Program Flow
![noname01](https://user-images.githubusercontent.com/21214309/48616221-4c77e880-e9d6-11e8-9d02-812279bd857c.png)

##### 1) 사용자의 신장정보를 받음
##### 2) 스마트폰의 이미지는 크기가 크므로 작은 사이즈로 Size Normalization 수행
##### 3) 이미지 왜곡 조정
  - Warpping using degree
  ![noname011](https://user-images.githubusercontent.com/21214309/48616222-4c77e880-e9d6-11e8-8b7a-8da631554fcc.png)
  - Android App에서 제공하는 스마트폰의 기울기 및 고도 정보를 바탕으로 Warpping을 수행
  - 기울어진 정도에 따라 위의 계산 방식을 이용해 이미지 왜곡 조정
  - Calibration 진행
  ![noname013](https://user-images.githubusercontent.com/21214309/48617107-d7f27900-e9d8-11e8-9b68-7ae27da27c78.png)
  - 내부 카메라 파라미터를 이용해 스마트폰 기종에 따른 Calibration 진행 

##### 4) 이미지의 배경 제거
  - 첫 번째 버전에서는 Grab-Cut Algorithm 사용
  - 두 번째 버전에서는 학습된 모델을 바탕으로 사람 객체를 인식하고 그 부위를 기준으로 Grab-Cut 진행
  ![noname01](https://user-images.githubusercontent.com/21214309/48617105-d7f27900-e9d8-11e8-9a2b-63acb956691f.png)
  - 세 번째 버전에서는 DCNN을 이용한 Deeplab을 이용해 Image Segmentation을 진행

##### 5) 이미지의 왜곽 특징 추출 (세 번째 버전에서는 불필요)
##### 6) 2개의 이미지를 객체의 머리 끝부터 발끝까지로 Cut
##### 7) 2개의 이미지 속의 객체 크기를 맞춰주기 위해 Resize 진행
##### 8) 각 신체 부위를 인식
  - 첫 번째, 두 번째 버전에서는 객체의 눈 높이 비율과 신체 각 부위의 비율에 따른 통계 방식으로 신체 부위 인식
  - 세 번째 버전에서는 DNN을 기반으로한 OpenPose에서의 Confidence Map을 통한 각 신체 부위 인식
  ![noname01](https://user-images.githubusercontent.com/21214309/48617210-24d64f80-e9d9-11e8-91ab-b148614ef2a7.png)

##### 9) 인식 후, 그 높이를 기준으로 객체의 첫점과 끝점을 계산 (Left : Third Version, Right : First Version)
![default](https://user-images.githubusercontent.com/21214309/48617104-d759e280-e9d8-11e8-807e-e3cf77068e8c.JPG)
##### 10) 2개의 이미지 각각의 신체 치수를 종합하여 계산
##### 11) 최종 각 신체 부위의 신체 치수를 반환

<br><br>

#### Result Avatar Information Flow
![noname01](https://user-images.githubusercontent.com/21214309/48617374-a75f0f00-e9d9-11e8-9468-d3d4f5a76140.png)

1) 사용자 체형정보와 DB에 저장된 옷의 수치들을 비교한다.
2) 각각의 수치에 맞는 최적의 사이즈를 구한다.
3) 각 부위의 결과 사이즈들이 일치하는지 확인한다.
4) 일치하지 않는 부위가 있다면 이 부위의 오차 값들을 비교한다.
5) 오차의 범위가 너무 클 경우 또는 각각의 최적 사이즈가 너무 상이할 경우는 해당 옷이 사용자의 체형에 맞지 않는다고 판단한다.
6) 약간의 낌/헐렁함은 있지만 심하지 않다면 해당 정보를 사용자에게 제공한다. 

<br>

##### First Version
Video URL : https://youtu.be/zMSdjQNTNw4 <br>
PDF File : [ShowU.pdf](https://github.com/YouMinJung/FittingSystem/files/2588666/ShowU.pdf) 

<br>
  
##### Final Version
PDF File :


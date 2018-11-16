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


#### Result Avatar Information Flow
1) 사용자 체형정보와 DB에 저장된 옷의 수치들을 비교한다.
2) 각각의 수치에 맞는 최적의 사이즈를 구한다.
3) 각 부위의 결과 사이즈들이 일치하는지 확인한다.
4) 일치하지 않는 부위가 있다면 이 부위의 오차 값들을 비교한다.
5) 오차의 범위가 너무 클 경우 또는 각각의 최적 사이즈가 너무 상이할 경우는 해당 옷이 사용자의 체형에 맞지 않는다고 판단한다.
6) 약간의 낌/헐렁함은 있지만 심하지 않다면 해당 정보를 사용자에게 제공한다. 

<br>

Video URL : https://youtu.be/zMSdjQNTNw4 <br>
PDF File : [ShowU.pdf](https://github.com/YouMinJung/FittingSystem/files/2588666/ShowU.pdf)

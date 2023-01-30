# vachineBook
มินิโปรเจคเป็นการฝึกพัฒนา res-api (laravel Lumen) กับ vue 3

วีดีโอรีวิว https://drive.google.com/file/d/17fJBrQ-PJ_vl8heg1COJN2ctP85lV_-b/view?usp=sharing

Folder app-api 
คือ Laravel Lumen ผู้พัฒนาใช้ php เวอร์ชั่น 8 ในการพัฒนา

Folder web
คือ vue 3 ผู้พัฒนาใช้ nodejs v14.17.4 , npm v7.21.1

วิธีการติดตั้ง
1.ติดตั้ง Laravel Lumen โดยเข้าไปใน Folder app-api แล้วใช้คำสั่ง composer install
จากนั้นให้เปลี่ยน .env.example เป็น .env และให้เซ็ตข้อมูลฐานข้อมูลที่เครื่องเราใช้อยู่
และใช้คำสั่ง php -S localhost:8100 -t public
เมื่อรันโปรเจคได้แล้วให้ใช้คำสั่ง php artisan migrate เพื่อ migrate โครงสร้างฐานข้อมูลครับ
** พอร์ทที่ใช้คือ 8100 จะเป็นตัวเชื่อมระหว่าง vuejs กับตัว Laravel Lumen ของเรา

2.ติดตั้ง vuejs โดยเข้าไปใน Folder web แล้วใช้คำสั่ง npm install
จากนั้นเปลี่ยน .env.example เป็น .env และให้เช็คว่า url ภายในนั้นเชื่อมตรงมาที่ Laravel Lumen ของเราถูกหรือไม่
และให้ใช้คำสั่ง npm run serve เพื่อทดสอบรันโปรเจคและใช้งาน

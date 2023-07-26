<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo.png') }}"  />
        <title>ระบบสารบรรณ</title>
    <!-- icon -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<style>
    @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
      body {
        font-family: "THSarabunNew";
        font-size: 18px;
        height: 100%;
      }
      .header{
        border: 1px solid black;
      }
      footer{
        position: fixed;
        bottom: 0;
        width: 100%;
        height: fit-content;
      }
      .editorContent table{
  width:fit-content;
  text-align: center;
  min-width: 30%;
}
.editorContent img{
  width: inherit;
}
.editorContent tr:first-child{
  border-bottom: 1px solid;
}

</style>
<!-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('dist/img/logoiddrives.png'))) }}" style=""  height="53"/> -->
<body>
    <article>
        <div style="text-align: center;border-bottom: 1px solid; line-height: 20px;margin-bottom: 10px;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('dist/img/logoiddrives.png'))) }}"  height="60"/>
            <p style="font-weight: bold; font-size: 18;margin-bottom: 0px;">บริษัท ไอดีไดรฟ์ จำกัด (สำนักงานใหญ่)</p>
            <p style="font-size: 14;line-height: 16px;margin-bottom: 0px;"> 200/222 หมู่2 ถนนชัยพฤกษ์ อำเภอเมืองขอนแก่น จังหวัดขอนแก่น Tel:043-228-899 <br>
                เลขที่ผู้เสียภาษี 0 4055 36000 53 1  Email: idofficer@iddrives.co.th
            </p>
            <p></p>
        </div>
        <div style="text-align: center;line-height: 20px;">
            <p style="font-weight: bold;font-size: 16;margin-bottom: 0px;">ประกาศที่ {{$form->book_num}}</p>
            <p style="font-weight: bold;font-size: 16;">เรื่อง {{$form->title}}</p>
        </div>
        <div class="editorContent" style="text-indent: 2.5em;line-height: 16px;">
            {!! $form->detail !!}
        </div>
    </article>
    <footer>
        <div>
            <p style="font-size: 16;margin-left: 40px;margin-bottom: unset;">มีผลบังคับใช้ตั้งแต่วันที่ {{$form->use_date}}</p>
            <p style="font-size: 16;margin-left: 40px;">ประกาศ ณ วันที่ {{$form->anno_date}}</p>
        </div>
        <div style="text-align: center;">
            <p style="font-size: 16;">จึงประกาศมาเพื่อทราบโดยทั่วกัน</p>
            <p style="margin-bottom: -5;font-size: 16;">..........................................</p>
            <p style="margin-bottom: -5;font-size: 16;">( {{$form->sign_name}} )</p>
            <p style="margin-bottom: -5;font-size: 16;">{{$form->sign_position}}</p>
            <p style="font-size: 16;">บริษัท ไอดีไดรฟ์ จำกัด</p>
        </div>
        <p style="text-align: center;border: 1px solid;width: 100%;font-size: 12px;padding-bottom: 5px;">
            เอกสารนี้ ฉบับทางการ จะอยู่ในรูปไฟล์อิเล็กทรอนิกส์ อยู่ในระบบเครือข่ายสารสนเทศ เท่านั้น หากปรากฎเอกสารนี้ส่วนหนึ่งส่วนใด 
            หรือทั้งฉบับในรูปสื่อกระดาษให้ตรวจสอบความทันสมัยกับฉบับทางการในระบบเครือข่ายสารสนเทศ ก่อนใช้อ้างอิง และทำลายทิ้งทันที 
            <br>หากพบว่าเป็นฉบับไม่ทันสมัย เอกสารนี้ เป็น สมบัติของบริษัท ไอดีไดรฟ์ จำกัดห้ามแจกจ่ายไปยังภายนอก โดยไม่ได้รับอนุญาตจาก กรรมการผู้จัดการ บริษัท ไอดีไดรฟ์ จำกัด
        </p>
    </footer>
</body>
</html>
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
        <table style="width: 100%;">
            <tbody >
                <tr style="border:1px solid;">
                    <td style="text-align: center;padding-top: 10px;line-height: 15px;border-right: 1px solid;">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('dist/img/logoiddrives.png'))) }}"  height="53"/>
                        <p>บริษัท ไอดีไดรฟ์ จำกัด</p>
                    </td>
                    <td style="text-align: center;line-height: 15px;max-width: 200px;min-width: 150px ; word-wrap: break-word;">
                        <p style="font-size: 20px;font-weight: bold;">นโยบาย</p>
                        <p style="font-size: 20px;font-weight: bold;padding: 0px 10px;">เรื่อง {{$form->title}}</p>
                    </td>
                    <td style="line-height: 5px;padding-top: 15px;border-left: 1px solid;padding-left: 10px;">
                        <p>เลขที่เอกสาร {{$form->book_num}}</p>
                        <p>แก้ไขครั้งที่ {{$form->edit_count}}</p>
                        <p>วันที่บังคับใช้ {{$form->created_date}}</p>
                        <p>หน้าที่ 1/1</p>
                    </td>
                </tr>
                <tr style="border:1px solid;line-height: 50%;">
                    <td style="border-right: 1px solid;padding-left: 10px;padding-top: 10px;">
                        <p>ผู้จัดทำ </p>
                        <p style="text-align: center;">{{$form->bcreater}}</p>
                    </td>
                    <td style="padding-left: 10px;padding-top: 10px;">
                        <p>ผู้ตรวจสอบ </p>
                        <p style="text-align: center;">{{$form->binspector}}</p>
                    </td>
                    <td style="border-left: 1px solid;padding-left: 10px;padding-top: 10px;">
                        <p>ผู้อนุมัติ </p>
                        <p style="text-align: center;">{{$form->bapprover}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="editorContent" style="text-indent: 2.5em;line-height: 16px;padding-left:1.5cm;padding-right:1cm">
            {!! $form->detail !!}
        </div>
    </article>
    <footer>
        <p style="text-align: center;border: 1px solid;width: 100%;font-size: 12px;padding-bottom: 5px;">
            เอกสารนี้ ฉบับทางการ จะอยู่ในรูปไฟล์อิเล็กทรอนิกส์ อยู่ในระบบเครือข่ายสารสนเทศ เท่านั้น หากปรากฎเอกสารนี้ส่วนหนึ่งส่วนใด 
            หรือทั้งฉบับในรูปสื่อกระดาษให้ตรวจสอบความทันสมัยกับฉบับทางการในระบบเครือข่ายสารสนเทศ ก่อนใช้อ้างอิง และทำลายทิ้งทันที 
            <br>หากพบว่าเป็นฉบับไม่ทันสมัย เอกสารนี้ เป็น สมบัติของบริษัท ไอดีไดรฟ์ จำกัดห้ามแจกจ่ายไปยังภายนอก โดยไม่ได้รับอนุญาตจาก กรรมการผู้จัดการ บริษัท ไอดีไดรฟ์ จำกัด
        </p>
    </footer>
</body>
</html>
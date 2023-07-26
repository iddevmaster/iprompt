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
        font-size: 16;
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
        <div style="text-align: center;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('dist/img/logoiddrives.png'))) }}"  height="60"/>
            <p style="margin-bottom: -5;font-size: 18;font-weight: bold;margin-bottom: 0;">บันทึกข้อตกลงความร่วมมือ เลขที่ {{$form->mou_num}}</p>
            <p style="margin-bottom: -5;font-size: 18;font-weight: bold;">เรื่อง {{$form->title}}</p>
            <p style="margin-bottom: -5;">ระหว่าง</p>
            <p style="margin-bottom: -5;">{{$form->party1}}</p>
            @foreach(json_decode($form->parties, true) as $party)
                <p class="mb-0">และ</p>
                <p class="mb-0">{{$party}}</p>
            @endforeach
            <p >บันทึกข้อตกลงนี้จัดทำขึ้น ณ {{$form->place}}</p>
        </div>
        <div class="editorContent" style="text-indent: 2.5em;line-height: 16px;">
            {!! $form->detail !!}
        </div>
    </article>
    <footer >
        <table style="width: 100%;">
            <tbody>
                <tr style="width: 100%;">
                    <td style="text-align: center;padding: 10px;">
                        <p style="margin-bottom: -5;font-size: 16;">..........................................</p>
                        <p style="margin-bottom: -5;font-size: 16;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
                        <p style="margin-bottom: -5;font-size: 16;">พยาน</p>
                    </td>
                    <td style="text-align: center;padding: 10px;">
                        <p style="margin-bottom: -5;font-size: 16;">..........................................</p>
                        <p style="margin-bottom: -5;font-size: 16;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
                        <p style="margin-bottom: -5;font-size: 16;">พยาน</p>
                    </td>
                </tr>
                <tr style="width: 100%;">
                    <td style="text-align: center;padding: 10px;">
                        <p style="margin-bottom: -5;font-size: 16;">..........................................</p>
                        <p style="margin-bottom: -5;font-size: 16;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
                        <p style="margin-bottom: -5;font-size: 16;">พยาน</p>
                    </td>
                    <td style="text-align: center;padding: 10px;">
                        <p style="margin-bottom: -5;font-size: 16;">..........................................</p>
                        <p style="margin-bottom: -5;font-size: 16;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
                        <p style="margin-bottom: -5;font-size: 16;">พยาน</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </footer>
</body>
</html>
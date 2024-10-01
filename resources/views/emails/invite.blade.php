{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Invite to Workspace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        h2 {
            color: #007bff;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .invite-form {
            margin-top: 20px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="email"]:focus,
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>You are invited to join <strong>{{ $workspaceName }}</strong></h1>
        <p>Click the button below to join:</p>
        <a href="{{ $linkInvite . '?email=' . urlencode($email) . '&authorize=' . urlencode($authorize) }}"
            class="btn">Join Workspace</a>
    </div>
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        h5 {
            color: #333;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .content-block {
            color: #495057;
            margin-bottom: 20px;
        }

        .content-block p {
            color: #878a99;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background-color: #0ab39c;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 500;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.2s;
        }

        a:hover {
            background-color: #099885;
            transform: scale(1.05);
        }

        footer {
            text-align: center;
            margin-top: 25px;
        }

        footer ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        footer a {
            color: #495057;
            font-weight: 600;
        }

        footer p {
            color: #98a6ad;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="row">
        <!--end col-->
        <div class="col-12">

            <table class="body-wrap"
                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin-top: -50px;">

                <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="container" width="600"
                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
                        valign="top">
                        <div class="content"
                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action"
                                itemscope itemtype=""
                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin-top: -150px; border: none;">
                                <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                                    <td class="content-wrap"
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;"
                                        valign="top">
                                        <meta itemprop="name" content="Confirm Email"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <tr>
                                                <div
                                                    class="justify-content-between d-flex align-items-center mt-3 mb-4">
                                                    <h5 class="mb-0 pb-1 text-decoration-underline">Mời bạn gia nhập
                                                        không gian làm việc!</h5>
                                                </div>
                                            </tr>
                                            <hr>
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block"
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 20px; line-height: 1.5; font-weight: 500; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                                    valign="top">
                                                    Chào, Fen thân yêu nhé !!!
                                                </td>
                                            </tr>
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block"
                                                    style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; line-height: 1.5; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 10px;"
                                                    valign="top">
                                                    Chúng tôi rất vui mừng thông báo rằng bạn đã được mời tham gia không
                                                    gian làm việc của chúng tôi trên Task Flow
                                                </td>
                                            </tr>
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block"
                                                    style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; line-height: 1.5; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px;"
                                                    valign="top">
                                                    Chúng tôi tin rằng sự tham gia của bạn sẽ mang lại giá trị lớn cho
                                                    đội ngũ và giúp chúng ta hoàn thành mục tiêu một
                                                    cách hiệu quả hơn.<br>
                                                    Trong không gian làm việc này, bạn sẽ có thể:<br><br>

                                                    - Theo dõi tiến độ dự án: Xem tất cả các nhiệm vụ và cập nhật
                                                    trạng thái của chúng.<br>
                                                    - Hợp tác dễ dàng: Chia sẻ ý tưởng, tài liệu và nhận phản hồi từ
                                                    các thành viên khác trong thời gian thực.<br>
                                                    - Lập kế hoạch thông minh: Sử dụng các công cụ lập kế hoạch để
                                                    quản lý thời gian và ưu tiên nhiệm vụ của
                                                    bạn.<br><br>

                                                    Hãy nhấn vào liên kết dưới đây để tham gia ngay bây giờ:
                                                </td>

                                            </tr>
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" itemprop="handler" itemscope itemtype=""
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 24px;"
                                                    valign="top">
                                                    <a href="{{ $linkInvite . '?email=' . urlencode($email) . '&authorize=' . urlencode($authorize) }}"
                                                        itemprop="url"
                                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: .8125rem;font-weight: 400; color: #FFF; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #0ab39c; margin: 0; border-color: #0ab39c; border-style: solid; border-width: 1px; padding: .5rem .9rem;"
                                                        onMouseOver="this.style.background='#099885'"
                                                        onMouseOut="this.style.background='#0ab39c'">Accept
                                                        &#8594;</a>
                                                </td>
                                            </tr>

                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; border-top: 1px solid #e9ebec;">
                                                <td class="content-block"
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0; padding-top: 15px"
                                                    valign="top">
                                                    <div style="display: flex; align-items: center;">
                                                        {{-- <img src="{{ asset('theme/assets/images/logo-light.png') }}"
                                                            alt="" height="35" width="35"
                                                            style="border-radius: 50px;"> --}}
                                                        <div style="margin-left: 8px;">
                                                            <span style="font-weight: 600;">Task Flow</span>
                                                            <p
                                                                style="font-size: 13px; margin-bottom: 0px; margin-top: 3px; color: #878a99;">
                                                                Quản lý không gian làm việc :33 </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="text-align: center; margin: 0px auto;">
                                <ul
                                    style="list-style: none;display: flex; justify-content: space-evenly; padding-top: 25px;padding-left: 0px; margin-bottom: 20px; font-family: 'Roboto', sans-serif;">
                                    <li>
                                        <a href="#" style="color: #495057;">Help Center</a>
                                    </li>
                                    <li>
                                        <a href="#" style="color: #495057;">Support 24/7</a>
                                    </li>
                                    <li>
                                        <a href="#" style="color: #495057;">Account</a>
                                    </li>
                                </ul>
                                <p
                                    style="font-family: 'Roboto', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">
                                    2022 Velzon. Design & Develop by Themesbrand</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <!-- end table -->
        </div>
        <!--end col-->
    </div><!-- end row -->
</body>

</html>

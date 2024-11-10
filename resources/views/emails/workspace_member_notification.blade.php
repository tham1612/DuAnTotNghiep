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
                    <td style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                        valign="top"></td>
                    <td class="container" width="600"
                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
                        valign="top">
                        <div class="content"
                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action"
                                itemscope itemtype="http://schema.org/ConfirmAction"
                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
                                <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                                    <td class="content-wrap"
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;"
                                        valign="top">
                                        <meta itemprop="name" content="Confirm Email"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block"
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                                    valign="top">
                                                    <div style="text-align: center;margin-bottom: 15px;">
                                                        <!-- <img src="assets/images/logo-dark.png" alt="" height="23"> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block"
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; line-height: 1.5; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;text-align: center; font-weight: 500;"
                                                    valign="top">
                                                    {{ $title }}
                                                </td>
                                            </tr>
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block"
                                                    style="font-family: 'Roboto', sans-serif; color: #878a99; line-height: 1.5; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;"
                                                    valign="top">
                                                    {{ $description }}
                                                </td>
                                            </tr>
                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                <td class="content-block" itemprop="handler" itemscope
                                                    itemtype="http://schema.org/HttpActionHandler"
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 24px; text-align: center;"
                                                    valign="top">
                                                    @if (!empty($action_text))
                                                        <a href="#" itemprop="url"
                                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: .8125rem;font-weight: 400; color: #FFF; text-decoration: none;text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #0ab39c; margin: 0; border-color: #0ab39c; border-style: solid; border-width: 1px; padding: .5rem .9rem;"
                                                            onMouseOver="this.style.background='#099885'"
                                                            onMouseOut="this.style.background='#0ab39c'">
                                                            {{ $action_text }}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; border-top: 1px solid #e9ebec;">
                                                <td class="content-block"
                                                    style="color: #878a99; text-align: center;font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0; padding-top: 15px"
                                                    valign="top">
                                                    Nếu bạn nhận được email này do nhầm lẫn, vui lòng xóa nó.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="text-align: center; margin: 0px auto;">
                                <ul
                                    style="list-style: none;display: flex; justify-content: space-evenly; padding-top: 25px;margin-bottom: 20px; padding-left: 0px; font-family: 'Roboto', sans-serif;">
                                    <li>
                                        <a href="#" style="color: #495057;">Trung tâm hỗ trợ</a>
                                    </li>
                                    <li>
                                        <a href="#" style="color: #495057;">Hỗ trợ 24/7</a>
                                    </li>
                                    <li>
                                        <a href="#" style="color: #495057;">Tài khoản</a>
                                    </li>
                                </ul>
                                <p
                                    style="font-family: 'Roboto', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">
                                    2024 Task Flow. Thiết kế & phát triển bởi đội ngũ TaskFlow</p>
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

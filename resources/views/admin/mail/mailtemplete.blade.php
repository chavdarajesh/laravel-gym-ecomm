<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME', 'Laravel App') }} Admin | Reset Password</title>
</head>

<body
    style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; -webkit-text-size-adjust:none">
    <center style="width: 100%; table-layout: fixed;">
        <div style="margin:10px;padding:10px;max-width:650px; margin:0 auto;" bgcolor="#ffffff">
            <table style="max-width:320px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fff">

                <tbody>
                    <tr>
                        <td style="padding:10px 10px">

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td bgcolor="#ffffff">
                                            <table width="600" align="center" style="margin:0 auto" cellpadding="0"
                                                cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding:40px 10px 0px 0px;background-color:#f9f9f9">
                                                            <table width="100%" cellpadding="0" cellspacing="0"
                                                                align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <th width="113" align="center">
                                                                            <table>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="line-height:0">
                                                                                            <a style="text-decoration:none"
                                                                                                href="{{route('front.home')}}">{{ env('APP_NAME', 'Laravel App') }}</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td bgcolor="#ffffff">
                                            <table width="600" align="center" style="margin:0 auto" cellpadding="0"
                                                cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding:0px 30px 10px" bgcolor="#f9f9f9">
                                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                                <tbody>

                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font:14px/16px Arial;color:#888;padding:0 0 23px">
                                                                            Hello<br>
                                                                            <br>
                                                                            You are receiving this email because we
                                                                            received a password reset request for your
                                                                            account.<br><br>
                                                                            <div
                                                                                style="text-align: center; margin-top: 15px">
                                                                                <a href="{{ route('admin.password.reset.get', $data['token']) }}"
                                                                                    style="height:40px;background-color:#009e13;border:2px solid #009e13;border-radius:50px;color:#ffffff;display:block;font-family:verdana,helvetica,sans-serif;font-size:18px;line-height:40px;text-align:center;text-decoration:none;width:185px;margin: 0 auto"
                                                                                    target="_blank">Reset Password</a>
                                                                            </div>
                                                                            <br>
                                                                            <br>
                                                                            <p style="line-height: 20px">
                                                                                If you did not request a password reset,
                                                                                no further action is required.
                                                                            </p>


                                                                            <p>Thank You !</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </center>
</body>

</html>

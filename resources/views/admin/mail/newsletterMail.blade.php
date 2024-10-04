<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultant Booking Meeting For {{ env('APP_NAME', 'Laravel App') }} </title>
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
                                                                            <br>

                                                                            {!! $data['content'] !!}
                                                                            <br>
                                                                            <br>
                                                                           
                                                                            <br>
                                                                            <p>Thank You !</p>
                                                                            <a target="_blank" href="{{route('front.newsletter.unsubscribe',['email'=>$data['encryptemail']])}}">unsubscribe</a>
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

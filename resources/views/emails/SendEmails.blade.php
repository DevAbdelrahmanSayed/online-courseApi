<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f5f5f5;">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; background-color: #ffffff;">
    <tr>
        <td align="center" bgcolor="#f5f5f5" style="padding: 20px 0;">
            <img src="https://example.com/logo.png" alt="Logo" width="150" style="display: block;">
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#ffffff" style="padding: 40px 0;">
            <h2 style="margin: 0; color: #333333;">Welcome. {{$name}}</h2>
            <p style="margin: 20px 0 30px; color: #666666;">Please verify your email address to get started.</p>
            <p style="margin: 20px 0 30px; color: #666666;">Your OTP is: <strong>{{ $otp }}</strong></p>
            <p style="margin: 20px 0 30px; color: #666666;">Thank you for choosing our platform!</p>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#f5f5f5" style="padding: 20px 0;">
            <p style="margin: 0; color: #999999;">If you have any questions, contact us at support@example.com</p>
        </td>
    </tr>
</table>
</body>
</html>

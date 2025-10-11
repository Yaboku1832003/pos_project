<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f7;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f4f7;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    
                    <tr>
                        <td align="center" style="padding: 40px 20px 20px 20px;">
                            <h1 style="margin: 0; color: #1a202c; font-size: 24px; font-weight: bold;">
                                Your Verification Code
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 30px 40px 30px;">
                            <p style="margin: 0 0 15px 0; color: #4a5568; font-size: 16px; line-height: 1.5;">
                                Hello,
                            </p>
                            <p style="margin: 0 0 25px 0; color: #4a5568; font-size: 16px; line-height: 1.5;">
                                Please use the following One-Time Password (OTP) to complete your action.
                            </p>
                            
                            <div style="background-color: #edf2f7; border-radius: 8px; text-align: center; padding: 15px 20px; margin-bottom: 25px;">
                                <h2 style="margin: 0; font-size: 42px; font-weight: bold; letter-spacing: 10px; color: #2d3748; font-family: 'Courier New', Courier, monospace;">
                                    {{ $otp }}
                                </h2>
                            </div>

                            <p style="margin: 0 0 25px 0; color: #718096; font-size: 16px; line-height: 1.5;">
                                This code is valid within <strong>60 seconds</strong>.
                            </p>
                            
                            <p style="margin: 0; color: #718096; font-size: 14px; line-height: 1.5;">
                                If you did not request this code, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 20px 30px; background-color: #edf2f7; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                             <p style="margin: 0; color: #718096; font-size: 14px;">
                                Thanks,<br><strong>Admin Zwal</strong>
                            </p>
                        </td>
                    </tr>

                </table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 20px auto;">
                    <tr>
                        <td align="center" style="padding: 10px 20px;">
                            <p style="margin: 0; color: #a0aec0; font-size: 12px;">
                                &copy; {{ date('Y') }} Zwal limited. All rights reserved.
                                <br>
                                Main Street, Taunggyi, Myanmar
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>

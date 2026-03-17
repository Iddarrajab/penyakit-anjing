<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
</head>

<body style="margin:0; padding:0; font-family:Arial, sans-serif; background-color:#f4f4f4;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
        <tr>
            <td align="center">

                <table width="400" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; padding:30px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <img src="https://merakiui.com/images/logo.svg" alt="Logo" style="height:30px;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td align="center" style="padding-bottom:10px;">
                            <h2 style="margin:0; color:#333;">Verifikasi OTP</h2>
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td align="center" style="color:#555; font-size:14px;">
                            Masukkan kode OTP berikut untuk verifikasi akun kamu:
                        </td>
                    </tr>

                    <!-- OTP -->
                    <tr>
                        <td align="center" style="padding:20px 0;">
                            <div style="
                                display:inline-block;
                                padding:12px 24px;
                                font-size:24px;
                                letter-spacing:6px;
                                font-weight:bold;
                                background:#1f2937;
                                color:#ffffff;
                                border-radius:6px;">
                                {{ $otp }}
                            </div>
                        </td>
                    </tr>

                    <!-- Expired -->
                    <tr>
                        <td align="center" style="color:#888; font-size:12px;">
                            Berlaku selama 5 menit
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding-top:20px; font-size:12px; color:#aaa;">
                            Jika kamu tidak meminta OTP ini, abaikan email ini.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
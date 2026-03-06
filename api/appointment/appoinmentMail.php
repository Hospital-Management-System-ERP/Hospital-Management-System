<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

function sendAppointmentMail($toEmail, $toName, $appointmentData)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cityhomecarenursingservice@gmail.com';
        $mail->Password   = 'xdabmdjnnqkcwywr'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('cityhomecarenursingservice@gmail.com', 'City Home Care Nursing Service Muzaffarpur');

        // USER MAIL ONLY
        if (!empty($toEmail)) {
            $mail->addAddress($toEmail, $toName ?: 'Patient');
        } else {
            return false;
        }

        $mail->isHTML(true);
        $mail->Subject = "Appointment Booking Confirmation";

        $body = '
        <div style="max-width:600px;margin:auto;font-family:Arial,Helvetica,sans-serif;
        background:#ffffff;border-radius:10px;box-shadow:0 4px 15px rgba(0,0,0,0.1);overflow:hidden">
        <div style="background:#0d6efd;color:#fff;padding:20px;text-align:center">
            <h2 style="margin:0;">Appointment Confirmation</h2>
            <p>City Home Care Nursing Service</p>
        </div>
        <div style="padding:20px">
        <p>
            Dear <b>' . htmlspecialchars($appointmentData['name']) . '</b>,<br>
            Your appointment has been successfully booked.
        </p>
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse">
            <tr>
                <td><b>Mobile</b></td>
                <td>' . htmlspecialchars($appointmentData['mobile']) . '</td>
            </tr>
            <tr>
                <td><b>Service</b></td>
                <td>' . ucwords($appointmentData['service']) . '</td>
            </tr>';
            if ($appointmentData['service'] === 'clinic' || $appointmentData['service'] === 'video') {
                $body .= '
                <tr>
                    <td><b>Doctor</b></td>
                    <td>' . htmlspecialchars($appointmentData['doctor']) . '</td>
                </tr>';
            }
            $body .= '
            <tr>
                <td><b>Date</b></td>
                <td>' . htmlspecialchars($appointmentData['date']) . '</td>
            </tr>
            <tr>
                <td><b>Time</b></td>
                <td>' . htmlspecialchars($appointmentData['time']) . '</td>
            </tr>
        </table>
            <p style="margin-top:20px">
                Thank you for choosing <b>City Home Care Nursing Service</b>.
            </p>
        </div>
        </div>';
        $mail->Body = $body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo);
        return false;
    }
}

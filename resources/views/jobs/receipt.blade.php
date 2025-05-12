<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $job->job_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px;
            line-height: 1.2;
        }
        .container {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .contact-info {
            font-size: 10px;
            color: #666;
            line-height: 1.1;
        }
        .receipt-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 8px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        th, td {
            padding: 3px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            width: 30%;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 8px 0 3px 0;
            background-color: #f5f5f5;
            padding: 3px;
        }
        .footer {
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            margin-top: 3px;
        }
        .cost-section {
            margin-top: 5px;
            text-align: right;
        }
        .total-cost {
            font-size: 13px;
            font-weight: bold;
        }
        .signatures {
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 25px;
            margin-bottom: 5px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .terms-section {
            margin-top: 5px;
            font-size: 7px;
            border: 1px solid #ddd;
            padding: 4px;
            line-height: 1.1;
        }
        .terms-title {
            font-weight: bold;
            margin-bottom: 2px;
        }
        .terms-list {
            margin: 0;
            padding-left: 12px;
        }
        .terms-list li {
            margin-bottom: 1px;
        }
        .notice-box {
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            padding: 4px;
            margin-top: 3px;
            font-size: 7px;
            line-height: 1.1;
        }
        .service-details {
            margin-top: 5px;
        }
        .side-by-side {
            width: 100%;
            border-collapse: collapse;
        }
        .side-by-side td {
            vertical-align: top;
            width: 50%;
            padding: 0 5px 0 0;
            border: none;
        }
        .side-by-side td:first-child {
            padding-right: 10px;
        }
        .side-by-side td:last-child {
            padding-left: 0;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            padding: 0;
            border: none;
            padding-bottom: 10px;
        }
        .signature-space {
            height: 40px; /* Add more space for signature */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="text-align: center; margin-bottom: 5px;">
                <img src="{{ public_path('logo.png') }}" alt="Laptop Expert Logo" style="height: 40px; max-width: 150px;">
            </div>
            <div class="logo">Laptop Expert (Pvt) Ltd - Service Center</div>
            <div class="contact-info">
                296/3/C, Delpe Junction, Ragama, Sri Lanka<br>
                Phone: 076 444 2221 | Email: info@laptopexpert.lk | Website: laptopexpert.lk
            </div>
        </div>

        <div class="receipt-title">SERVICE JOB RECEIPT</div>

        <div class="receipt-details">
            <table>
                <tr>
                    <th>Receipt No:</th>
                    <td>REC-{{ $job->job_number }}</td>
                    <th>Date:</th>
                    <td>{{ $date }}</td>
                </tr>
                <tr>
                    <th>Job Number:</th>
                    <td colspan="3">{{ $job->job_number }}</td>
                </tr>
            </table>
        </div>

        <table class="side-by-side">
            <tr>
                <td>
                    <div class="section-title">CUSTOMER INFORMATION</div>
                    <table>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $job->customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Phone Number 1:</th>
                            <td>{{ $job->customer->formatted_phone_number_1 ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Phone Number 2:</th>
                            <td>{{ $job->customer->formatted_phone_number_2 ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Home Phone:</th>
                            <td>{{ $job->customer->formatted_home_phone_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>WhatsApp:</th>
                            <td>{{ $job->customer->formatted_whatsapp_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $job->customer->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $job->customer->email ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <div class="section-title">DEVICE INFORMATION</div>
                    <table>
                        <tr>
                            <th>Device Type:</th>
                            <td>{{ $job->device_type }}</td>
                        </tr>
                        <tr>
                            <th>Brand/Model:</th>
                            <td>{{ $job->brand ?? 'N/A' }} {{ $job->model ? '/ ' . $job->model : '' }}</td>
                        </tr>
                        <tr>
                            <th>Serial Number:</th>
                            <td>{{ $job->serial_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Received Date:</th>
                            <td>{{ $job->received_date->format('Y-m-d') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="service-details">
            <div class="section-title">SERVICE DETAILS</div>
            <table>
                <tr>
                    <th>Issue Description:</th>
                    <td colspan="3">{{ $job->issue_description }}</td>
                </tr>
                @if($job->diagnosis)
                <tr>
                    <th>Diagnosis:</th>
                    <td colspan="3">{{ $job->diagnosis }}</td>
                </tr>
                @endif
                @if($job->resolution)
                <tr>
                    <th>Resolution:</th>
                    <td colspan="3">{{ $job->resolution }}</td>
                </tr>
                @endif
                @if($job->notes)
                <tr>
                    <th>Additional Notes:</th>
                    <td colspan="3">{{ $job->notes }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="cost-section">
            <table>
                <tr>
                    <th style="width:70%">Estimated Service Charge:</th>
                    <td class="total-cost">LKR {{ number_format($job->cost, 2) }}</td>
                </tr>
            </table>
            <p style="font-size: 8px; font-style: italic; text-align: right; margin-top: 2px; margin-bottom: 0;">* This amount is an estimate and may be subject to change.</p>
        </div>

        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-space"></div>
                    <div class="signature-line"></div>
                    <div>Customer Signature</div>
                </td>
                <td>
                    <div class="signature-space"></div>
                    <div class="signature-line"></div>
                    <div>Company Representative</div>
                </td>
            </tr>
        </table>
        
        <div class="terms-section">
            <div class="terms-title">Terms and Conditions:</div>
            <ol class="terms-list">
                <li>Repairs will only proceed after customer provides verbal or written consent. If additional issues are discovered during repair, you will be contacted immediately with updated estimate and recommendations.</li>
                <li>Customers are responsible for backing up their data. The Laptop Expert Pvt Ltd is not liable for data loss during repair.</li>
                <li>Repairs may come with a limited warranty (30–90 days) on parts and labor. Physical damage or liquid spills after repair void the warranty.</li>
                <li>Devices not collected within 30 days of repair completion may incur storage fees or be considered abandoned.</li>
                <li>Full payment is due upon completion of repairs. Devices will not be released until payment is made in full.</li>
                <li>Software issues, viruses, and customer-inflicted damage after repair are not covered under any repair warranty.</li>
                <li>Repair times and costs depend on the availability of replacement parts. In some cases, parts may need to be ordered, which may extend the repair timeline.</li>
                <li>Timeframes vary based on the issue and parts availability.</li>
                <li>By submitting your laptop for repair, you authorize us to perform necessary repairs based on the initial diagnosis.</li>
                <li>If the issue cannot be resolved (e.g., severe motherboard damage), we will inform you of the findings and suggest possible alternatives, including replacement options.</li>
            </ol>
        </div>

        <div class="notice-box">
            <div class="terms-title">Important Notice regarding "No Power" issues:</div>
            <p>When a laptop is brought in with a "no power" issue, we are unable to assess the functionality of other components such as the keyboard, display, battery, or internal hardware until the device is powered on. Our first step is to restore power to the laptop. Once the laptop is operational, we will conduct a thorough diagnostic to evaluate the condition of all other components. If any additional issues are identified, we will inform you and provide recommendations for further repairs.</p>
        </div>

        <div class="notice-box">
            <div class="terms-title">BitLocker Encryption:</div>
            <p>When your laptop is repaired (especially if it involves chip replacement or BIOS changes), BitLocker encryption may be activated. If this happens, you'll need your BitLocker recovery key to access your data. Without the BitLocker key, the data cannot be recovered.</p>
            <p><strong>Your Responsibility:</strong> Keep your BitLocker recovery key safe before bringing your laptop in. If you lose the recovery key, data loss may occur. The Laptop Expert Pvt Ltd. not responsible for any data loss due to BitLocker encryption issues. Please ensure the key is backed up securely.</p>
        </div>

        <div class="footer">
            <p>Thank you for choosing Laptop Expert (Pvt) Ltd! This receipt serves as proof of service.</p>
        </div>
    </div>
</body>
</html> 
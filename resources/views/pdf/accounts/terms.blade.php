<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Funeral Subscription Terms & Conditions</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.0;
            margin: 20px 50px;
            text-align: left;
        }

        .logo {
            text-align: center !important;
            margin-bottom: 10px;
        }

        .logo img {
            max-height: 50px;
        }

        .header {
            text-align: center !important;
            margin-bottom: 15px;
        }

        h2, h3 {
            margin-bottom: 5px;
        }

        h2 {
            text-align: center !important;
        }

        h3 {
            margin-top: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }

        .signature {
            margin-top: 20px;
        }

        .signature div {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="logo">
        <img src="{{ public_path('logo-zeebu.png') }}" alt="{{ config('app.name') }}">
    </div>

    <h2>Terms and Conditions</h2>
    <p class="header">
        <strong>Funeral Subscription Plan</strong>
    </p>
    <table>
        <tbody>
            <tr>
                <td><strong>Effective Date:</strong> {{ date('d M Y') }}</td>
                <td><strong>Company:</strong> [Funeral Home Name]</td>
                <td><strong>Registration No.:</strong> [Reg Number]</td>
            </tr>
            <tr>
                <td><strong>Address:</strong> [Your Address]</td>
                <td><strong>Email:</strong> [your@email.com]</td>
                <td><strong>Phone:</strong> [Your Contact Number]</td>
            </tr>
        </tbody>
    </table>

    <h3>1. Definitions</h3>
    <p>"Subscriber" means the person who subscribes to the funeral plan.<br>
    "Beneficiaries" refer to the individuals listed under the plan for funeral benefits.</p>

    <h3>2. Eligibility</h3>
    <p>Applicants must be South African citizens or legal residents aged 18 and above.</p>

    <h3>3. Subscription Packages</h3>
    <p>Subscribers must select from available packages and disclose all required personal and beneficiary details.</p>

    <h3>4. Payments</h3>
    <p>Monthly payments are due on the specified date. Non-payment may result in suspension or cancellation.</p>

    <h3>5. Waiting Periods</h3>
    <p>Benefits apply after a waiting period (e.g. 6 months). Accidental death may be exempt.</p>

    <h3>6. Claims Procedure</h3>
    <p>Claims must be submitted within 3 months of death with ID, death certificate, and proof of relationship.</p>

    <h3>7. Exclusions</h3>
    <p>No benefits for deaths caused by suicide within 12 months, fraud, or undisclosed pre-existing conditions.</p>

    <h3>8. Cancellations and Lapses</h3>
    <p>You may cancel with 30 days’ notice. Lapsed accounts may be reinstated after review and backdated payment.</p>

    <h3>9. Amendments</h3>
    <p>We reserve the right to update terms. Notice of changes will be given via email or postal address.</p>

    <h3>10. Confidentiality and POPIA Compliance</h3>
    <p>All client information is protected under the Protection of Personal Information Act.</p>

    <h3>11. Dispute Resolution</h3>
    <p>Disputes shall first attempt resolution via internal mechanisms. If unresolved, they may be referred to the FSCA or arbitration.</p>

    <h3>12. Limitation of Liability</h3>
    <p>We are not liable for any indirect damages or third-party issues beyond policy scope.</p>

    <h3>13. Acceptance</h3>
    <p>By signing this document, you agree to the terms and conditions herein.</p>

    @if(count($beneficiaries)<0)
        <h3>14. List of Beneficiaries</h3>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>ID Number</th>
                    <th>Relationship</th>
                    <th>Date of Birth</th>
                    <th>Contact Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beneficiaries as $beneficiary)
                    <tr>
                        <td>{{ $beneficiary['name'] }}</td>
                        <td>{{ $beneficiary['id'] }}</td>
                        <td>{{ $beneficiary['relationship'] }}</td>
                        <td>{{ $beneficiary['dob'] }}</td>
                        <td>{{ $beneficiary['contact'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="signature">
        <div><strong>Subscriber Signature:</strong> ____________________________</div>
        <div><strong>Full Name:</strong> ______________________________________</div>
        <div><strong>Date:</strong> ____________________________________________</div>
    </div>

</body>
</html>

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
            margin: 10px 20px;
            text-align: left;
        }

        .logo {
            text-align: center !important;
            margin-bottom: 5px;
        }

        .logo img {
            max-height: 45px;
        }

        .header {
            text-align: center !important;
            margin-bottom: 5px;
        }

        h2, h3 {
            margin-bottom: 3px;
        }

        h2 {
            text-align: center !important;
        }

        h3 {
            margin-top: 10px;
            font-size: 10px !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th, td {
            border: 1px solid #662466;
            padding: 8px;
            text-align: left;
        }

        .signature {
            margin-top: 10px;
        }

        .signature div {
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="logo">
        <img src="{{ public_path('logo-zeebu.png') }}" alt="{{ config('app.name') }}">
    </div>

    <h2>Terms & Conditions</h2>
    <p class="header">
        <strong>Funeral Subscription Plan</strong>
    </p>
    <table>
        <tbody>
            <tr>
                <td width="33.3%"><strong>Effective Date:</strong><br> {{ date('d M Y') }}</td>
                <td width="33.3%"><strong>Company:</strong><br> {{ setting('registered_name') }}</td>
                <td width="33.3%"><strong>Registration No:</strong><br> {{ setting('registration_number') }}</td>
            </tr>
            <tr>
                <td width="33.3%"><strong>Address:</strong><br> {{ setting('main_address') }}</td>
                <td width="33.3%"><strong>Email:</strong><br> {{ setting('main_email') }}</td>
                <td width="33.3%"><strong>Phone:</strong><br> {{ setting('main_phone') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>1. Definitions</h3>
    @php
        $client = $account->client;
    @endphp
    <p>
        "Client" means the person who subscribes to the funeral plan.<br>
        &nbsp;&nbsp;&nbsp;Fullname: <b>{{ strtoupper($client->name) }}</b>, ID: <b>{{$client->id_number }}</b>, Phone: <b>{{$client->phone }}</b><br>
        &nbsp;&nbsp;&nbsp;Address: <b>{{$client->address }}</b>.<br>
        "Beneficiaries" refer to the individuals listed under the plan for funeral benefits.
    </p>
    <h3>2. Eligibility</h3>
    <p>Applicants must be South African citizens or legal residents aged 18 and above.</p>

    <h3>3. Subscription Packages</h3>
    <p>Clients must select from available packages and disclose all required personal and beneficiary details.</p>

    <h3>4. Payments & Annual Increase</h3>
    <p>Monthly payments are due on the specified date. Non-payment may result in suspension or cancellation.
        Monthly contribution will increase by 5% annually from 1 July.
    </p>

    <h3>5. Waiting Periods & Claims Procedure<</h3>
    <p>Benefits apply after a waiting period (e.g. 6 months). Accidental death may be exempt.
        Claims must be submitted within 3 months of death with ID, death certificate, BI 1663 notice of death and proof of relationship.
    </p>

    <h3>6. Exclusions & Amendments</h3>
    <p>No benefits for deaths caused by suicide within 12 months, fraud, or undisclosed pre-existing conditions.
        We reserve the right to update terms. Notice of changes will be given via email or postal address.
    </p>

    <h3>7. Cancellations & Lapses</h3>
    <p>You may cancel with 30 days’ notice. Lapsed accounts may be reinstated after review and backdated payment.</p>

    <h3>8. Confidentiality & POPIA Compliance</h3>
    <p>All client information is protected under the Protection of Personal Information Act.</p>

    <h3>9. Dispute Resolution</h3>
    <p>Disputes shall first attempt resolution via internal mechanisms. If unresolved, they may be referred to the FSCA or arbitration.</p>

    <h3>10. Limitation of Liability</h3>
    <p>We are not liable for any indirect damages or third-party issues beyond policy scope.</p>

    <h3>11. Acceptance</h3>
    <p>By signing this document, you agree to the terms and conditions herein.</p>

    <h3>12. Selected Plan</h3>
    @php
        $mainPackage = $account->packages()->where('main', true)->first();
        $additionalPackages = $account->packages()->where('main', false);
    @endphp
    <p>
        Package: {{ $mainPackage->name }} <br>
        Reference: {{ $account->slug }} <br>
        Monthly Contribution: {{ sprintf('%s%.2f', 'R', $mainPackage->contribution) }} <br>
        Additional Packages: {{ $additionalPackages->count() }} / {{ sprintf('%s%.2f', 'R', $additionalPackages->sum('contribution')) }} <br>
        Beneficiaries: {{ count($beneficiaries) }} <br>
    </p>

    @if(count($beneficiaries)<0)
        <h3>13. List of Beneficiaries</h3>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>ID Number</th>
                    <th>Relationship</th>
                    <th>Contact Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beneficiaries as $beneficiary)
                    <tr>
                        <td>{{ $beneficiary->name }}</td>
                        <td>{{ $beneficiary->id_number }}</td>
                        <td>{{ $beneficiary->relationship }}</td>
                        <td>{{ $beneficiary->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="signature">
        <div>
            <strong>Client Signature:</strong> _______________________________
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Date:</strong> _____________________________________________
        </div>
        <div>
            <strong>Full Name:</strong> ______________________________________
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Place:</strong> ____________________________________________
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risk Assessment Report - {{ $assessmentSession->session_name }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 10px;
        }
        .title {
            font-size: 20pt;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
        }
        .meta-text {
            text-align: right;
            font-size: 10pt;
            color: #64748b;
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 25px;
            margin-bottom: 15px;
            border-left: 4px solid #dc2626;
            padding-left: 8px;
        }
        .metrics-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .metrics-box {
            width: 33.33%;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            padding: 15px;
            text-align: center;
        }
        .metrics-box h3 {
            margin: 0 0 5px 0;
            font-size: 22pt;
            color: #0f172a;
        }
        .metrics-box p {
            margin: 0;
            font-size: 9pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px;
            font-size: 10pt;
        }
        .data-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10pt;
            vertical-align: top;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
            text-align: center;
        }
        .badge-high { background-color: #ffeeef; color: #dc2626; border: 1px solid #fecaca; }
        .badge-medium { background-color: #fffbeb; color: #d97706; border: 1px solid #fef3c7; }
        .badge-low { background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-status { background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="title">CRAS Risk Assessment Report</td>
            <td class="meta-text">
                Generated: {{ date('M d, Y') }}<br>
                Status: <strong>{{ $assessmentSession->status }}</strong>
            </td>
        </tr>
    </table>

    <p style="margin-top:0;">
        <strong>Audit Target Session:</strong> {{ $assessmentSession->session_name }}<br>
{{ \Carbon\Carbon::parse($assessmentSession->start_date)->format('M d, Y') }} to {{ $assessmentSession->end_date ? \Carbon\Carbon::parse($assessmentSession->end_date)->format('M d, Y') : 'Ongoing Execution' }}
    </p>

    @php
        $risks = $assessmentSession->riskAssessments;
        $total = $risks->count();
        $high = $risks->where('risk_classification', 'High')->count();
        $med = $risks->where('risk_classification', 'Medium')->count();
        $low = $risks->where('risk_classification', 'Low')->count();
        $resolved = $risks->where('status', 'Resolved')->count() + $risks->where('status', 'Accepted')->count();
        $progress = $total > 0 ? round(($resolved / $total) * 100) : 0;
    @endphp

    <div class="section-title">Session-Wide Matrix Analytics</div>
    <table class="metrics-table">
        <tr>
            <td class="metrics-box">
                <h3>{{ $total }}</h3>
                <p>Total Vulnerabilities</p>
            </td>
            <td class="metrics-box" style="border-left:none; border-right:none;">
                <h3>{{ $high }}</h3>
                <p>High Severity Threats</p>
            </td>
            <td class="metrics-box">
                <h3>{{ $progress }}%</h3>
                <p>Remediation Rate</p>
            </td>
        </tr>
    </table>

    <div class="section-title">Identified Vulnerability & Asset Register</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 20%;">Asset</th>
                <th style="width: 35%;">Threat Description</th>
                <th style="width: 35%;">Vulnerability & Mitigation</th>
                <th style="width: 10%; text-align: center;">Risk</th>
            </tr>
        </thead>
        <tbody>
            @forelse($risks as $risk)
                <tr>
                    <td>
                        <strong>{{ $risk->asset->asset_name ?? 'N/A' }}</strong><br>
                        <span style="font-size: 8pt; color: #64748b;">{{ $risk->asset->asset_type ?? 'N/A' }}</span><br>
                        <span style="font-size: 8pt; color: #64748b;">Score: {{ $risk->risk_score }} (L:{{ $risk->likelihood }} × I:{{ $risk->impact }})</span><br>
                        <span class="badge badge-status" style="margin-top: 3px;">{{ $risk->status }}</span>
                    </td>
                    <td>
                        <div style="margin-bottom: 8px;">
                            <strong style="color: #dc2626; font-size: 9pt;">THREAT:</strong><br>
                            <span style="font-size: 9pt;">{{ $risk->threat_description }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="margin-bottom: 8px;">
                            <strong style="color: #d97706; font-size: 9pt;">VULNERABILITY:</strong><br>
                            <span style="font-size: 9pt;">{{ $risk->vulnerability_description }}</span>
                        </div>
                        @if($risk->mitigation_plan)
                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #e2e8f0;">
                            <strong style="color: #16a34a; font-size: 9pt;">MITIGATION PLAN:</strong><br>
                            <span style="font-size: 9pt;">{{ $risk->mitigation_plan }}</span>
                        </div>
                        @else
                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #e2e8f0;">
                            <strong style="color: #94a3b8; font-size: 9pt;">MITIGATION PLAN:</strong><br>
                            <span style="font-size: 9pt; color: #94a3b8; font-style: italic;">No mitigation plan provided.</span>
                        </div>
                        @endif
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        @if($risk->risk_classification == 'High')
                            <span class="badge badge-high">HIGH</span>
                        @elseif($risk->risk_classification == 'Medium')
                            <span class="badge badge-medium">MED</span>
                        @else
                            <span class="badge badge-low">LOW</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #64748b; padding: 20px;">No risk items recorded inside this evaluation timeline.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Cybersecurity Risk Assessment System (CRAS) Compliance Log &bull; Page 1 of 1
    </div>

</body>
</html>
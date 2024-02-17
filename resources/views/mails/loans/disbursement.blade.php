
<!DOCTYPE html>
<html>
    <head>
        <title>Loan Disbursement Confirmation</title>
    </head>
    <body>
        <h3>Dear {{$loan->user->first_name}},</h3>
        <p>We hope this message finds you in good health. We are pleased to inform you that your loan application with Glaze Credit has been successfully processed and your funds have been disbursed. <strong>Congratulations!</strong></p>

        <p>Loan Details:<ul>
            <li>Loan Amount:  <?php echo (ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format($loan->amount)));?> ({{$loan->amount}}) naira</li>
            <li>Loan Account Number: {{$loan->unique_id}}</li>
            <li>Loan Type: {{$loan->type->name}}</li>
            <li>Interest Rate: {{$loan->type->rate}} per annum</li>
            <li>Loan Term: {{$loan->duration}} {{$loan->frequency}}</li>
        </ul></p>

        <p>Your loan funds have been transferred to the bank account you provided during the application process. Please allow 6 hours for the funds to reflect in your account, depending on your bank's processing times.</p>

        <p>If you have any questions or need further assistance, please do not hesitate to contact our customer support team at {{$loan->account_officer->phone}} or email us at {{config('app.email')}}. Our dedicated team is here to assist you with any queries you may have.</p>

        <p>Thank you for choosing {{config('app.name')}} for your financial needs. We value your trust and look forward to serving you in the future. We wish you the very best in achieving your financial goals.</p>

        <p>Sincerely, <br />
        <br />
        <br />{{$loan->account_officer->first_name}} {{$loan->account_officer->last_name}}
        <br />Customer Service Representative
        <br />{{$loan->account_officer->phone}} | {{$loan->account_officer->email}}
        <br />{{config('app.name')}}
        </p>
    </body>
</html>
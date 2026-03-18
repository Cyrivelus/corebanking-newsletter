<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #374151; margin: 0; padding: 0; background-color: #f3f4f6; }
        .wrapper { width: 100%; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: 8px; shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #4f46e5; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px 0; font-size: 16px; color: #4b5563; }
        .footer { text-align: center; padding-top: 20px; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        .unsubscribe-link { color: #4f46e5; text-decoration: underline; }
        .btn-box { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="logo">CoreBanking</div>
                <div style="font-size: 12px; color: #6b7280;">Actualités & Notifications</div>
            </div>

            <div class="content">
                <p>Bonjour <strong>{{ $subscriber->name ?? 'Cher abonné' }}</strong>,</p>

                <div style="white-space: pre-wrap; margin: 20px 0;">
                    {!! nl2br(e($content)) !!}
                </div>

                <p>Merci de votre fidélité,<br>L'équipe CoreBanking</p>
            </div>

            <div class="footer">
                <p>Cet e-mail a été envoyé à {{ $subscriber->email }}.</p>
                <p>
                    Vous ne souhaitez plus recevoir nos messages ?
                    <a href="{{ route('newsletter.unsubscribe', ['email' => $subscriber->email]) }}" class="unsubscribe-link">
                        Se désabonner ici
                    </a>
                </p>
                <p>&copy; {{ date('Y') }} CoreBanking. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>
</html>

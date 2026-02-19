{{-- resources/views/emails/newsletter-welcome.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue à notre newsletter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #2563eb; color: white; padding: 20px; text-align: center;">
            <h1>Bienvenue {{ $subscriber->name ?: 'cher abonné' }} !</h1>
        </div>

        <div style="padding: 20px; background-color: #f9f9f9;">
            <p>Merci de vous être inscrit à notre newsletter.</p>

            <p>Vous recevrez désormais :</p>
            <ul>
                <li>Nos dernières actualités</li>
                <li>Offres exclusives</li>
                <li>Conseils et astuces</li>
            </ul>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('newsletter.unsubscribe', $subscriber->token) }}"
                   style="color: #666; text-decoration: none; font-size: 12px;">
                    Se désinscrire
                </a>
            </div>
        </div>

        <div style="text-align: center; padding: 20px; color: #666; font-size: 12px;">
            <p>&copy; {{ date('Y') }} CoreBanking. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>

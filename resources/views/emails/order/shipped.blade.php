<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Expédiée</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">

<table align="center" width="600" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
    <tr>
        <td style="text-align: center; padding: 20px; background-color: #007bff; color: white; border-radius: 10px 10px 0 0;">
            <h2>🚀 Votre commande a été expédiée !</h2>
        </td>
    </tr>

    <tr>
        <td style="padding: 20px;">
            <p>Bonjour <strong>{{ $order->user->name }}</strong>,</p>
            <p>Votre commande <strong>#{{ $order->id }}</strong> a été expédiée. Vous trouverez la facture en pièce jointe.</p>

            <table width="100%" style="border-collapse: collapse; margin-top: 20px;">
                <thead>
                <tr>
                    <th style="border-bottom: 2px solid #007bff; text-align: left; padding-bottom: 10px;">Produit</th>
                    <th style="border-bottom: 2px solid #007bff; text-align: right; padding-bottom: 10px;">Quantité</th>
                    <th style="border-bottom: 2px solid #007bff; text-align: right; padding-bottom: 10px;">Prix</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td style="padding: 10px 0;">{{ $item->book->title }}</td>
                        <td style="text-align: right;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($item->price, 2, ',', ' ') }} €</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h3 style="text-align: right; margin-top: 20px;">Total : {{ number_format($order->total_price, 2, ',', ' ') }} €</h3>

            <p style="text-align: center; margin-top: 30px;">
                <a href="{{ route('orders.show', $order->id) }}" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    Voir ma commande
                </a>
            </p>

            <p style="margin-top: 20px;">Merci d'avoir commandé chez nous ! 😊</p>
        </td>
    </tr>

    <tr>
        <td style="text-align: center; padding: 10px; background-color: #f1f1f1; border-radius: 0 0 10px 10px;">
            <small>&copy; 2025 Boutique en ligne. Tous droits réservés.</small>
        </td>
    </tr>
</table>

</body>
</html>


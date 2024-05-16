<?php 
use Carbon\Carbon;
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Devis Template</title>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top" >
                <td class='titre'>
                    DEVIS
                </td>
                <td rowspan="2" style="text-align: right;  vertical-align: top;">
                    <img src="{{ $image }}"  class='image'>
                </td>
            </tr>
            <tr>
                <td class='dates'>
                    Nº DEVIS : {{ $serie }}<br>
                    DATE DEMANDE : {{ $demande->date_demande }}<br>
                    DATE D'EXPIRATION : {{ $expiration }}<br>
                </td>
            </tr>
            </tr>
            <tr>
                <td  class='info'>
                    Client : {{ $parent['nom'].' '.$parent->prenom }}<br>
                    E-mail : {{ $parent->email }}<br>
                    Tél : {{ $parent->telephone_portable }}<br>
                    Fixe : {{ $parent->telephone_fixe }}<br>
                </td>
                
                <td  class='info' style='text-align: left;'>
                    Offre : {{ $offre->titre }}<br>
                    Période d’offre : {{ $offre->date_debut.' a '.$offre->date_fin }}<br>
                    Remise : {{ $offre->remise.' %' }}<br>
                    Option de paiement : {{ $optionPaiment }}
                </td>
            </tr>
            
        </table>
            
        <table class="tg">
            <colgroup>
                <col span="4">
                <col span="1">
            </colgroup>
			<thead>
				<tr>
				    <th class='prix'>ENFANT</th>
				    <th class='prix'>ACTIVITE</th>
				    <th class='prix'>SEANCES / SEMAINE</th>
				    <th class='prix'>EFFICTIF ACTUEL</th>
				    <th class='prix'>TARIF UNITAIRE</th>
				</tr>
			</thead>
			
			<tbody>
                @foreach ($enfantsActivites as $item)
				<tr>
					<td class='td'>{{ $item['enfant'] }}</td>
					<td class='td'>{{ $item['activite'] }}</td>
					<td class='td'>{{ $item['seances'] }}</td>
					<td class='td'>{{ $item['effictif'] }}</td>
					<td class='tdPrix' class='dataPrix'>{{ $item['tarif'] }} DH</td>
				</tr>
                @endforeach
                
				<tr>
					<td colspan="3" rowspan="4" class='hidden'></td>
					<td class="prix">SOUS TOTAL</td>
					<td class="tdPrix">{{ $prixHT }} DH</td>
				</tr>
                <tr>
					<td class="prix">AVEC REMISE</td>
					<td class="tdPrix">{{ $prixRemise }} DH</td>
				</tr>
                <tr>
					<td class="prix">TVA</td>
					<td class="tdPrix">{{ $TVA }} %</td>
				</tr>
                <tr>
					<td class="prix">TOTAL (TTC)</td>
					<td class="prixBottomRight">{{ $TTC }} DH</td>
				</tr>
                
			</tbody>
		</table>
        <div style='padding-bottom: 25px'>
            <h3 class='description'>DESCRITPION D'OFFRE</h3>
            <p class='text'>{{ $offre->description }}</p>
        </div>
        <div>
            <p class='text' style="padding-bottom: 15px">Pour accepter ce devis, signez ici et renvoyez : ____________________________________________________<br>ou Acceper sur la plateform.</p><br>
            <p class='text'>Devis établi le : {{ Carbon::now('Africa/Casablanca')->addHours(1)->toDateTimeString() }}</p>
            <p class='merci'>MERCI POUR VOTRE CONFIANCE !</p>
        </div>
        

     	

   
    
		<style type="text/css">
                @font-face {
                font-family: 'Ford Antenna';
                src: url({{ public_path('fonts/Ford Antenna TTF/FordAntenna-Regular.ttf')}}) format('truetype');
                }
                @font-face {
                font-family: 'Ford Antenna SemiBold';
                src: url({{ public_path('fonts/Ford Antenna TTF/FordAntenna-Semibold.ttf')}}) format('truetype');
                }
                @font-face {
                font-family: 'Ford Antenna Black';
                src: url({{ public_path('fonts/Ford Antenna TTF/FordAntenna-Black.ttf')}}) format('truetype');
                }
                .description{ font-family: Ford Antenna SemiBold ;font-size: 25px;padding-top: 100px}
                .merci{color: #10278a;font-family: Ford Antenna SemiBold ;font-size: 16px;}
                .dates{color: #10278a; font-family: Ford Antenna SemiBold ;font-size: 15px;padding-bottom:30px;line-height: 1.6;}
                .titre{color: #10278a; font-family: Ford Antenna Black ;font-size: 50px;padding-bottom:35px;}
                .info{font-family: Ford Antenna;font-size: 14px;padding-bottom: 35px;line-height: 1.8; }
                .image{width:46%; max-width:300px;}
                .first{border-inline-start-color: black;}
                .tg  {text-align: left; font-family: Ford Antenna;font-size: smaller;padding:5px 10px;border-collapse:collapse;}
                .text{text-align: left; font-family: Ford Antenna;}
                .tg .hidden{border:transparent;}
                .tg .td{border:ridge black 1px;padding:5px 10px;}
                .tg .tdPrix{border:ridge black 1px;padding:5px 10px; text-align: right;background-color: #f2f2f2}
                .tg .prixBottomRight{border:ridge black 1px;padding:5px 10px;text-align: right; font-family: Ford Antenna SemiBold;color: white;background-color: #FF6C22; font-size: 15px}
                .tg .dataPrix{border:ridge black 1px;text-align-last: right;}
                .tg .prix{border:ridge black 1px;padding: 5px 10px;font-family: Ford Antenna SemiBold;color: white;background-color: #FF6C22; }
                .invoice-box {
                    padding: 30px;
                    line-height: 24px;
                    color: #373636;
                }
                
                .invoice-box table {
                    width: 100%;
                }
                
        </style>
	
 </div>
</body>
</html>
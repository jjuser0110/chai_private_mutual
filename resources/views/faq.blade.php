@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">FAQ</div>
</div>

<div id="page-content">
    <div class="faq-content" style="padding:10px;color:rgb(136, 136, 136);font-size:12px;line-height:1.5;">
        <p>1. What is HLG Private Placement?</p>
        <p>
            This is a private placement platform owned by HLGroup. It has a certain threshold for multiple investments. It is only open and available to a certain number of certified people who have gone through a preset filter. The investors’ money will only be used in corporate and municipal projects that require external funding. Completed projects will have a dividend payout and will be promptly refunded if the ongoing project fails.
        </p>
        
        <p>2. For some higher-quality projects, an appointment for investors to preview the project will be made before external fundraising;</p>
        <p>
            During the preview period, you can make an appointment to subscribe. After the subscription is successfully processed, the platform will selectively distribute shares to platform users, which is a minimum of one share.
        </p>
        
        <p>3. Why am i given a larger number of shares?</p>
        <p>
            Depending on the time of a project’s subscription, the amount of shares obtained from the project will also be different, and the subscription will only be successful at one share.
        </p>
        
        <p>4. What is a credit score?</p>
        <p>
            Credit score is the platform’s overall evaluation of a user’s qualification. The availability to participate in higher-quality private placement projects are based on a user’s credit score, a user with a high credit score may join higher-quality projects such as architectural private placement projects, while a user with low credit score may only join lower threshold projects such as NFT.
        </p>
        
        <p>5. What is the difference between public placement and private placement?</p>
        <p>
            The criteria for fundraising are different. Public placement is a fundraising platform for the general public, which has a lower threshold but bigger sample capacity. The objective of private placement, is to target a smaller, pre-selected audience with a higher threshold of investment.
        </p>
        
        <p>6. Is the concept of private placement illegal?</p>
        <p>
            The act of private placement is completely legal. The purpose is to support the cultivation of certain enterprises and governmental resources, increase development in public welfare while handing out profits to singular investors. It has received approval and legal backing as such in CMS Law.
        </p>
        
        <p>7. Purpose of the platform’s shop and prices;</p>
        <p>
            The items that can be purchased in the platform’s shop view are on purchasable using the points given to users instead of direct currency.
        </p>
        
        <p>8. Is this platform safe? Will my information be disclosed?</p>
        <p>
            Yes. The Confidentiality Of Private Placement Cannot Be Compared To That Of Public Placement. Those Who Can Participate Are Of Refined Status And Quality-checked, The Platform Has A Confidentiality Agreement In Place That Protects Users' Personal Information Rights. The Platform Uses Different Payment Methods To Protect The Privacy Of Investors And The Safety Of Their Funds;
        </p>
        <p>
            (High Nett-worth Individuals Do Not Want The Government To Know Their Actual Asset-value To Avoid Being Taxed)
        </p>
        
        <p>9. Will my principal not be refunded if the fundraising is unsuccessful or the project fails?</p>
        <p>
            If the fundraising is unsuccessful or the project fails, the deposit will be refunded. Before investing in a project, the platform will sign an investor principal protection agreement with the investor and your principal will be refunded if the project fails
        </p>
        
        <p>10. What is an NFT?</p>
        <p>
            NFTs or Non-Fungible Tokens are a kind of cryptocurrency that represents a one-of-a-kind digital asset or unique piece of artwork. Fiat and cryptocurrencies are mainly used for transactional purposes and are fungible, which means each unit can be interchanged for certain values.
        </p>
        
        <p>11. What is the Metaverse?</p>
        <p>
            A metaverse is an improved digital environment where it is possible to move seamlessly between work, play, shopping, socializing and creativity in one digital landscape.
        </p>
        <p>
            What form that landscape will take is a subject of debate. Firms such as Meta (Facebook) are investing heavily in an immersive experience, where users with wearable hardware discard reality for a purely virtual world, interacting via avatars – the basis for the ‘Oasis’ depicted in Ernest Cline’s novel, Ready Player One.
        </p>
        <p>
            The metaverse can be valued at a certain amount of digital currency and can be bought, traded, or sold using external sources.
        </p>

        <br>
        <p>What is Credit Score?</p>
        <ul class="ps-3">
            <li>Credit value introduction After Register as a HLFund User, the initial credit value is 80 Score. The credit limit is 100 Score.</li>
            <li>Joining 10 Project in HLFund recruitment activity and completing it, you can contact customer service to redeem 1 credits Score.</li>
            <li>When the credit value reaches 100 Score, User account will be allowing to join High Com Project Once a month.</li>
        </ul>

        <p>Reminders</p>
        <ol class="ps-3">
            <li>User whose credit value is less than 60 Score will affect the Functions.</li>
            <li>Once any User is detected to take advantage of illegal operations, the corresponding credit value will be deducted.</li>
        </ol>

        <p>Points Description</p>
        <ol class="ps-3">
            <li>Redemption Eligibility: Ordinary member and above and participate redemption from integral shop</li>
            <li>Every RM 500 of recharge will accumulate 5 Point</li>
        </ol>
        <div class="divider"></div>
        <div class="divider"></div>
    </div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
</script>
@endsection
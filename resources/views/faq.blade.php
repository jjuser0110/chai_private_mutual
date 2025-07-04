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
            HLG Private Placement is an exclusive investment platform owned and operated by HLGroup. It maintains a selective entry threshold, available only to a limited number of certified investors who have passed a pre-qualification screening process.
            <br><br>
            Investor funds are allocated solely to carefully vetted corporate and municipal projects that require external financing. Upon successful project completion, investors receive dividend payouts as stipulated. In the event that a project does not proceed as planned, the principal capital will be promptly refunded in accordance with the platform’s risk management protocols.
        </p>
        
        <p>2. What Is a Credit Score?</p>
        <p>
            A credit score represents the platform’s comprehensive assessment of a user's investment eligibility and credibility. Investors with higher credit scores are granted access to premium private placement projects—such as architecture investments—while those with lower scores may only participate in entry-level projects, such as NFTs or digital collectibles.
        </p>
        
        <p>3. Is the Platform Safe? Will My Information Be Disclosed?</p>
        <p>
            Yes, the platform ensures strict confidentiality. Private placement requires a higher standard of investor screening, and all participants are bound by non-disclosure agreements (NDAs). Personal data is protected under advanced encryption protocols, and multi-layered payment systems are used to safeguard both privacy and funds.<br>
            (Note: High-net-worth individuals often prefer discreet platforms to avoid overexposure or unnecessary taxation.)
        </p>
        
        <p>4. Project Preview for Selected Investors</p>
        <p>
            For premium-grade projects, a private preview session may be arranged for qualified investors prior to the official launch of external fundraising. This ensures informed decision-making and early access to high-potential opportunities.
        </p>
        
        <p>5. Is Private Placement Legal?</p>
        <p>
            Yes, private placement is fully legal. Its primary purpose is to support targeted enterprises and government-backed initiatives through controlled fundraising. Investors benefit from profit-sharing while contributing to public development. All operations comply with the Capital Markets and Services Act (CMSA) and are legally endorsed.
        </p>
        
        <p>6. Why Am I Allocated a Larger Number of Shares?</p>
        <p>
            The number of shares allocated depends on the subscription timing. Early subscribers often receive more favorable allocations. Each successful subscription secures only one unit of share; allocations vary based on availability at the time of entry.
        </p>
        
        <p>7. What Is the Difference Between Public Placement and Private Placement?</p>
        <p>
            Public placements are open to the general public, featuring lower investment thresholds and wider audience reach. In contrast, private placements are limited to a pre-screened group of investors and require a higher qualification threshold. The objective is to maintain exclusivity, investor protection, and project quality control.
        </p>
        
        <p>8. Purpose of the Platform’s Shop and Pricing System</p>
        <p>
            The platform’s marketplace allows users to redeem exclusive items using accumulated points. These points are issued as part of the reward and participation system and cannot be purchased with real currency, ensuring fairness and internal ecosystem integrity.
        </p>
        
        <p>9. Will My Principal Be Refunded If the Fundraising Fails or the Project Collapses?</p>
        <p>
            Yes. In the event of unsuccessful fundraising or project failure, your initial capital will be fully refunded. Prior to investment, the platform enters into a Principal Protection Agreement with each investor to legally safeguard the original deposit against loss.
        </p>
        
        <p>10. What Is the Metaverse?</p>
        <p>
            The Metaverse is an immersive digital environment that integrates work, entertainment, social interaction, and commerce into one seamless experience.
        </p>
        <p>
            Corporations like Meta (formerly Facebook) are developing metaverse platforms where users interact through avatars in fully virtual landscapes—similar to the concept portrayed in Ready Player One.
        </p>
        <p>
            Digital real estate and assets within the metaverse can be bought, sold, or traded using cryptocurrencies or other digital currencies.
        </p>
        
        <p>11. What Is an NFT?</p>
        <p>
            NFTs (Non-Fungible Tokens) are unique digital assets authenticated via blockchain technology. Unlike cryptocurrencies such as Bitcoin, NFTs are not interchangeable and often represent exclusive artwork, collectibles, or digital property, each holding a distinct value in the digital economy.
        </p>
        <br>
        <p>12. What Is Credit Score?</p>
        <p>📌 Credit Score System Overview:</p>
        <ul class="ps-3">
            <li>Upon registering as an HLFund user, you will be assigned an initial credit score of 80 points.</li>
            <li>The maximum credit score is 100 points.</li>
        </ul>
        <p>🧩 How to Earn Credit Points:</p>
        <ul class="ps-3">
            <li>Successfully participate in 10 HLFund recruitment projects, then contact customer support to redeem 1 credit point.</li>
            <li>When your credit score reaches 100 points, your account will be eligible to participate in High-Commission Projects once per month.</li>
        </ul>
        <p>🔔 Important Reminders:</p>
        <ul class="ps-3">
            <li>Users with a credit score below 60 points may experience restricted access to certain platform features.</li>
            <li>Any fraudulent or manipulative behavior will result in an immediate deduction of credit points.</li>
        </ul>
        <p>💎 Points System Description:</p>
        <ul class="ps-3">
            <li>Redemption Eligibility: Available to Ordinary Members and above.</li>
            <li>Points can be redeemed in the Rewards Shop for exclusive benefits.</li>
            <li>For every RM 500 deposited, you will receive 5 points automatically.</li>
        </ul>
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
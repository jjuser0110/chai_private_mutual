@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">About Us</div>
</div>

<div id="page-content">
    <div style="color:white;padding:10px;">
        <img src="{{ asset('/img/about/logo-hongleong-rect.png') }}" alt="Hong Leong Bank Logo" class="d-block mx-auto mb-3">

        <!-- About Hong Leong Group -->
        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Hong Leong Group is a conglomerate of core businesses founded on the fundamental philosophy of managing businesses for long-term, sustainable value creation.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Our companies span key sectors of the economy, including financial services, manufacturing and distribution, property development and investment, hospitality and leisure, consumer goods, healthcare, and principal investments.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Our presence extends across Southeast Asia, Greater China, Europe, and Oceania.
        </p>

        <p style="text-align:center; color:rgb(0, 102, 204);">
            We believe that the key to long-term value creation lies in the coexistence of entrepreneurialism with professional management, discipline, and governance.
        </p>

        <!-- Our Story Section -->
        <h2 style="text-align:center; color:red;">-Our Story-</h2>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            The journey of the Hong Leong Group began in 1963, the same year the nation of Malaysia was formed.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Our entrepreneurial journey mirrors Malaysia’s economic growth and industrialisation over the decades.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            We started as a building materials trading company, operating from a small shop lot in Kuala Lumpur. From there, our founders identified and seized opportunities presented by a rapidly developing economy.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            We transitioned from trading to manufacturing building materials. Soon, we expanded into other high-growth industries such as property development, banking, financial services, and various other sectors that we invested in along the way.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Our story is not merely one of growth.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            It is a story of entrepreneurial spirit harmonising with professionalism in the way we approach business. We apply this same philosophy to how we envision the future and pursue innovation.
        </p>

        <!-- CSR Section -->
        <p style="text-align:center;">
            <strong style="color:rgb(0, 102, 204);">-Corporate Social Responsibility-</strong>
        </p>

        <p style="color:rgb(187, 187, 187);">
            Our purpose is not just profit for profit’s sake. Our existence must also contribute to the betterment of society.
        </p>

        <p style="color:rgb(187, 187, 187);">
            We strive for this by continuously advocating sustainable practices in the way we operate our businesses. We believe that this approach promotes long-term value creation for our stakeholders and brings positive impact to the communities around us.
        </p>

        <p style="color:rgb(187, 187, 187);">
            We are strong believers in investing in education to change and improve the lives of people. This is why we continue to invest in scholarships and community development initiatives to positively impact those who need it the most.
        </p>

        <p style="color:rgb(187, 187, 187);">
            Our Corporate Social Responsibility, led by the Hong Leong Foundation, aligns our approach to sustainability with our companies’ pursuit of meaningful CSR endeavours.
        </p>

        <p style="text-align:center; color:rgb(0, 102, 204);">
            The Hong Leong Group is built on the strong heritage of value creation for our stakeholders and communities within which we operate.
        </p>

        <!-- Our Businesses Section -->
        <h2 style="text-align:center; color:red;">-Our Businesses-</h2>

        <img src="{{ asset('/img/about/hlb-financial-services.png') }}" alt="Financial Services" class="w-100 mb-3">
        <img src="{{ asset('/img/about/hlb-manufacturing.png') }}" alt="Manufacturing" class="w-100 mb-3">
        <img src="{{ asset('/img/about/hlb-hospitality-leisure.png') }}" alt="Hospitality & Leisure" class="w-100 mb-3">
        <img src="{{ asset('/img/about/hlb-property.png') }}" alt="Property" class="w-100 mb-3">
        <img src="{{ asset('/img/about/hlb-principle-investment.png') }}" alt="Principal Investments" class="w-100 mb-3">
        <img src="{{ asset('/img/about/hlb-food.png') }}" alt="Food" class="w-100 mb-3">

        <p></p>

        <!-- Investment Protection Section -->
        <p style="text-align:center; color:white;"><strong>-Investment Protection-</strong></p>

        <img src="{{ asset('/img/about/logo-bursa-malaysia.png') }}" alt="Bursa Malaysia Logo" class="w-100 mb-3">

        <!-- About Bursa Malaysia -->
        <p style="text-align:center;">
            <strong style="color:rgb(0, 102, 204);">ABOUT BURSA MALAYSIA</strong>
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            <em>We reveal the pulse of diverse opportunities for those seeking to expand or invest with meaningful impact.</em>
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            Bursa Malaysia is an exchange holding company incorporated in 1976 and listed in 2005.
            As one of the largest bourses in ASEAN, Bursa Malaysia facilitates capital-raising for over 900 companies—
            whether through the Main Market for established large-cap companies,
            the ACE Market for emerging companies of various sizes, or the LEAP Market for growing SME companies.
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            As an inclusive marketplace, Bursa Malaysia provides seamless access to a wide range of investment products and services,
            connecting both domestic and international market participants to opportunities that enable expansion and impactful investments.
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            Bursa Malaysia’s diverse product portfolio includes equities, derivatives, offshore and Islamic assets,
            along with Exchange Traded Funds (ETFs), Real Estate Investment Trusts (REITs),
            and Exchange Traded Bonds and Sukuk (ETBS).
        </p>

        <!-- About the SC -->
        <img src="{{ asset('/img/about/logo-suruhanjaya-security.png') }}" alt="Suruhanjaya Sekuriti" class="w-100 mb-3">

        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>ABOUT THE SC</strong></span>
        </p>

        <p style="color:rgb(187, 187, 187);">
            The Securities Commission Malaysia (SC) was established on 1 March 1993 under the
            <em>Securities Commission Act 1993 [SCA]</em>.
            As a self-funded statutory body, we are entrusted with the responsibility to regulate and develop the Malaysian capital market.
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            Our mission is “to promote and maintain fair, efficient, secure, and transparent securities and derivatives markets,
            while facilitating the orderly development of an innovative and competitive capital market.”
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            The SC is directly responsible for rule-making, enforcing regulations related to the capital market,
            ensuring sustainable market growth and development, supervising capital market activities,
            and overseeing market institutions such as exchanges, clearing houses, and registered market operators.
            We also regulate all entities and individuals licensed under the
            <em>Capital Markets and Services Act 2007</em>.
            In line with the SCA, the SC reports to the Minister of Finance, and our accounts are presented to Parliament annually.
        </p>

        <!-- SC Responsibilities -->
        <p style="text-align:center; color:rgb(187, 187, 187);">
            <strong>Our areas of responsibilities include:</strong>
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            1. Developing the overall capital market and its various segments, such as the equity market, bond and sukuk market, Islamic capital market, fund management, derivatives, and other market-based platforms and services;
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            2. Driving innovation and digital transformation within the capital market;
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            3. Creating opportunities for a sustainable financing ecosystem;
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            4. Ensuring the proper conduct of all market participants through our supervisory, surveillance, and enforcement roles;
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            5. Advocating for strong corporate governance practices; and
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            6. Facilitating greater cross-border regulatory cooperation and fostering thought leadership.
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            At the core of all our work is a steadfast focus on investors.
            Our primary mandates to regulate and ensure market growth are always pursued with the aim of protecting investors,
            including initiatives to enhance their financial and investment literacy.
        </p>

        <!-- Location Section -->
        <h2 style="text-align:center; color:rgb(230, 0, 0);">-LOCATION-</h2>

        <img src="{{ asset('/img/about/hlb-map.png') }}" alt="HLB Map" class="w-100 mb-3">

        <p style="text-align:center; color:rgb(204, 232, 204);">
            Level 1 Menara Hong Leong, No. 6, Jalan Damanlela, Bukit Damansara, 50490 Kuala Lumpur
        </p>

        <p>&nbsp;</p>

        <!-- INVESTOR PROTECTION -->
        <p>INVESTOR PROTECTION</p>

        <!-- Description Of Project Partners -->
        <p class="mb-0"><strong>Description Of Project Partners:</strong></p>
        <p>
            <span style="color:rgb(136, 136, 136); font-size:12px;">
                Only connect with high-quality project institutions/financial institutions,
                conduct 360-degree due diligence before cooperation, dynamic management during cooperation,
                continuous and effective risk monitoring, and isolate risks from the source.
                A professional risk management team will implement dynamic monitoring of the investment target throughout the entire process.
                We adhere to advanced concepts and rely on a professional ecological risk control system
                to build a safe and secure financial transaction information service platform for the majority of users to ensure product safety.
                The scope of information collected is limited to relevant information necessary for the company’s needs and business conduct,
                in order to improve the efficiency and quality of services provided.
            </span>
        </p>

        <!-- Investor Protection -->
        <p class="mb-0"><strong>Investor Protection:</strong></p>
        <p>
            <span style="color:rgb(136, 136, 136); font-size:12px;">
                Investors must pass multiple security certifications such as real-name authentication and mobile phone binding before depositing and withdrawing money. Any withdrawal of account funds can only be transferred to the bank bound with the investor’s real name. The account fully guarantees the safety of the transfer of investor funds. Data encryption protection technology: Using SSL 256-bit data transmission encryption technology, when customers perform personal account management, recharge, cash withdrawal, and other operations, the information is automatically encrypted to ensure safe transmission of information. All fund operations will be completed through the procedure of “specialized personnel operation and special personnel review.”
            </span>
        </p>

        <!-- Privacy And Security -->
        <p class="mb-0"><strong>Privacy And Security:</strong></p>
        <p>
            <span style="color:rgb(136, 136, 136); font-size:12px;">
               The information provided by customers will be kept strictly confidential, and a strict security system will be set up to prevent any unauthorized person, including the company’s staff, from obtaining customer information and to ensure security. Before investing in investor funds, the project will also undergo evaluation and verification to ensure the rationality and robustness of each project, and to safeguard investors’ capital flow. To provide better customer service and products, we ensure that all information provided by investors is kept confidential.
            </span>
        </p>

        <!-- Legal Protection -->
        <p class="mb-0"><strong>Legal Protection:</strong></p>
        <p>
            <span style="color:rgb(136, 136, 136); font-size:12px;">
                The establishment, review, and public subscription of all investment projects on the platform are overseen by a professional legal team, which operates in line with Malaysia’s policies and regulations. This ensures that investors’ returns on the platform are legal and effective. At the same time, the platform continues to innovate and develop other private equity projects. Under the strict supervision of public trust institutions, it fully leverages the advantages of Internet + S.
            </span>
        </p>

        <!-- Membership Level Description -->
        <p class="mb-0"><strong>MEMBERSHIP LEVEL DESCRIPTION</strong></p>
        <p>
            <span style="color:rgb(136, 136, 136); font-size:12px;">
                “HLGPP” is fully committed to the field of high-quality financial investment, creating superior services for the majority of users.
            </span>
        </p>

        <p>&nbsp;</p>

        <!-- Ordinary Member -->
        <p class="mb-1">Ordinary Member:</p>
        <ul class="list-unstyled p-0">
            <li>1. Participation eligibility in projects within the range of less than RM 50,000.</li>
            <li>2. Ordinary membership is valid for 12 days.</li>
        </ul>

        <!-- Silver Member -->
        <p class="mb-1">
            Silver Member:
            <span style="color:rgb(230, 0, 0);"> Invest TOTAL RM50,000 (WITHIN 24 HOURS)</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>1. Participation eligibility in projects within the range of RM50,000 - RM100,000.</li>
            <li>2. No charge on processing fees.</li>
        </ul>

        <!-- Gold Member -->
        <p class="mb-1">
            Gold Member:
            <span style="color:rgb(230, 0, 0);"> Invest TOTAL RM100,000 (WITHIN 24 HOURS)</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>1. Participation eligibility in projects within the range of RM100,000 - RM500,000.</li>
            <li>2. Entitlement to make multiple appointments.</li>
            <li>3. No charge on processing fees.</li>
            <li>4. No charge on withdrawal fees.</li>
        </ul>

        <!-- Platinum Member -->
        <p class="mb-1">
            Platinum Member:
            <span style="color:rgb(230, 0, 0);"> Invest TOTAL RM500,000 (WITHIN 24 HOURS)</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>1. Participation eligibility in projects within the range of RM500,000 - RM1,000,000.</li>
            <li>2. Entitlement to make multiple appointments.</li>
            <li>3. No charge on processing fees.</li>
            <li>4. No charge on withdrawal fees.</li>
            <li>5. Invitation to participate in HLG’s Annual “Singapore Fortune 500 Enterprise Exchange Conference” (The specific date will be notified to you by the dedicated staff).</li>
            <li>6. Entitlement to usage of a 48-foot private yacht up to 3 times a year, with a maximum of 5 pax each time. (If the upgrade is successful, you can submit relevant certificates to the official personnel to apply for usage rights.)</li>
        </ul>

        <!-- Diamond Member -->
        <p class="mb-1">
            Diamond Member:
            <span style="color:rgb(230, 0, 0);"> Invest TOTAL RM1,000,000 (WITHIN 24 HOURS)</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>1. Participation eligibility in projects within the range of RM1,000,000 - RM5,000,000.</li>
            <li>2. Entitlement to make multiple appointments.</li>
            <li>3. No charge on processing fees.</li>
            <li>4. No charge on withdrawal fees.</li>
            <li>5. Invitation to participate in HLG’s Annual Conference.</li>
            <li>6. Entitlement to usage of a 48-foot private yacht up to 3 times a year, with a maximum of 5 pax each time. (If the upgrade is successful, you can submit relevant certificates to the official personnel to apply for usage rights.)</li>
            <li>7. Annual entitlement of a 2-pax private jet global flight experience. (If the upgrade is successful, you can submit relevant certificates to the official personnel to apply for usage rights.)</li>
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
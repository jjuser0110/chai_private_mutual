@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">About Us</div>
</div>

<div id="page-content">
    <div style="color:white;padding:10px;">
        <img src="{{ asset('/img/about/hongleong.jpeg') }}" alt="Hong Leong Bank Logo" class="d-block mx-auto mb-3" style="width:100%">

        <!-- About Hong Leong Group -->
        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Hong Leong Group is a diversified multinational conglomerate built upon a core philosophy of driving long-term, sustainable value through disciplined management and forward-thinking entrepreneurship.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Our business portfolio spans across strategic sectors of the global economy, including:
        </p>
        <ul class="ps-3">
            <li>Financial services</li>
            <li>Manufacturing and distribution</li>
            <li>Property development and investment</li>
            <li>Hospitality and leisure</li>
            <li>Consumer goods</li>
            <li>Healthcare</li>
            <li>Principal investments</li>
        </ul>

        <p style="text-align:center; color:rgb(0, 102, 204);">
            With an established presence across Southeast Asia, Greater China, Europe, and Oceania, we are committed to delivering impact beyond borders.<br>
At Hong Leong Group, we believe that enduring value is achieved through the synergy of entrepreneurial agility, professional management, robust governance, and operational excellence.
        </p>

        <!-- Our Story Section -->
        <h2 style="text-align:center; color:red;">-Our Story-</h2>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            The journey of Hong Leong Group began in 1963—coinciding with the founding of the nation of Malaysia.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Our entrepreneurial path has evolved in parallel with the country’s economic transformation and industrialisation. What began as a humble building materials trading business operating from a small shop lot in Kuala Lumpur soon became a launchpad for broader ambitions.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            Recognising the immense opportunities in a rapidly developing economy, our founders transitioned the business from trading to manufacturing, and subsequently expanded into high-growth sectors such as property development, banking, financial services, and strategic investments across multiple industries.
        </p>

        <p class="text-justify" style="color:rgb(187, 187, 187);">
            But our story is not just about growth—it is about vision, resilience, and the synergy between entrepreneurship and professionalism. This foundational philosophy continues to guide our approach to innovation and our pursuit of a future defined by purposeful impact.
        </p>

        <!-- CSR Section -->
        <p style="text-align:center;">
            <strong style="color:rgb(0, 102, 204);">-Corporate Social Responsibility-</strong>
        </p>

        <p style="color:rgb(187, 187, 187);">
            At Hong Leong Group, our purpose extends beyond profit. We are committed to contributing meaningfully to the betterment of society.
        </p>

        <p style="color:rgb(187, 187, 187);">
            We champion sustainability across all our business operations—firmly believing that responsible practices not only create long-term stakeholder value but also generate a lasting, positive impact on the communities we serve.
        </p>

        <p style="color:rgb(187, 187, 187);">
            A key pillar of our CSR efforts lies in empowering through education. We invest in scholarships and community development programs to uplift lives and open doors for those in need.
        </p>

        <p style="color:rgb(187, 187, 187);">
            Our CSR initiatives are spearheaded by the Hong Leong Foundation, which serves as the driving force behind our commitment to social responsibility. Through the Foundation, we align our sustainability goals with impactful programs that reflect our Group’s broader mission of inclusive progress.
        </p>

        <p style="text-align:center; color:rgb(0, 102, 204);">
            Hong Leong Group is anchored in a strong heritage of value creation—for our stakeholders, our communities, and the generations to come. 
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
            <em>We unveil the heartbeat of diverse opportunities—empowering those who seek to expand, invest, and create meaningful impact across industries and borders.</em>
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            Bursa Malaysia is a fully integrated exchange holding company, incorporated in 1976 and listed in 2005. As one of the largest and most dynamic bourses in ASEAN, Bursa Malaysia plays a pivotal role in facilitating capital formation for over 900 listed companies.
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            These companies span a range of growth stages, supported through:
        </p>
        <ul class="ps-3">
            <li>The Main Market – for well-established, large-cap corporations</li>
            <li>The ACE Market – tailored for high-potential, emerging businesses</li>
            <li>The LEAP Market – designed specifically to support the capital needs of Small and Medium Enterprises (SMEs)</li>
            <li>As an inclusive and innovation-driven marketplace, Bursa Malaysia offers seamless access to a comprehensive suite of investment products and services—connecting both domestic and global investors with growth opportunities that deliver tangible impact.</li>
        </ul>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            Our product offerings include:
        </p>
        <ul class="ps-3">
            <li>Equities</li>
            <li>Derivatives</li>
            <li>Offshore and Islamic assets</li>
            <li>Exchange-Traded Funds (ETFs)</li>
            <li>Real Estate Investment Trusts (REITs)</li>
            <li>Exchange-Traded Bonds and Sukuk (ETBS)</li>
        </ul>

        <p>Bursa Malaysia continues to evolve as a resilient and trusted platform for sustainable capital markets—powering economic development and investment confidence across the region.
        </p>
        <!-- About the SC -->
        <img src="{{ asset('/img/about/logo-suruhanjaya-security.png') }}" alt="Suruhanjaya Sekuriti" class="w-100 mb-3">

        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>About the Securities Commission Malaysia (SC)</strong></span>
        </p>

        <p style="color:rgb(187, 187, 187);">
            The Securities Commission Malaysia (SC) was established on 1 March 1993 under the Securities Commission Act 1993 (SCA). As a self-funded statutory body, the SC is mandated to regulate and develop Malaysia’s capital market, ensuring its integrity, resilience, and long-term sustainability.
        </p>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            Our mission is clear:
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            "To promote and maintain fair, efficient, secure, and transparent securities and derivatives markets, while facilitating the orderly development of an innovative and competitive capital market."
        </p>

        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>Our Core Functions</strong></span>
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            The SC is responsible for:
        </p>
        <ul class="ps-3">
            <li>Formulating and enforcing regulations that govern the Malaysian capital market</li>
            <li>Supervising licensed entities, registered operators, and capital market intermediaries</li>
            <li>Overseeing market institutions, including exchanges, clearing houses, and central depositories</li>
            <li>Driving sustainable capital market growth, in line with national economic objectives</li>
            <li>We regulate all individuals and entities licensed under the Capital Markets and Services Act 2007 (CMSA) and operate under the oversight of the Minister of Finance, to whom we report. The SC's audited accounts are tabled before Parliament annually, in accordance with the SCA.</li>
        </ul>

        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>Key Areas of Responsibility</strong></span>
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            Developing the Capital Market Ecosystem
        </p>
        <ul class="ps-3">
            <li>Formulating and enforcing regulations that govern the Malaysian capital market</li>
        </ul>

        <p style="text-align:center; color:rgb(187, 187, 187);">
            Fostering Innovation and Digital Transformation
        </p>
        <ul class="ps-3">
            <li>Encouraging fintech solutions and next-generation market infrastructure.</li>
        </ul>
        
        <p style="text-align:center; color:rgb(187, 187, 187);">
            Advancing Sustainable Finance
        </p>
        <ul class="ps-3">
            <li>Creating an enabling environment for green investments and ESG-aligned financing.</li>
        </ul>
        
        <p style="text-align:center; color:rgb(187, 187, 187);">
            Ensuring Market Integrity and Compliance
        </p>
        <ul class="ps-3">
            <li>Through comprehensive supervisory, surveillance, and enforcement frameworks.</li>
        </ul>
        
        <p style="text-align:center; color:rgb(187, 187, 187);">
            Strengthening Corporate Governance
        </p>
        <ul class="ps-3">
            <li>Promoting transparency, accountability, and ethical business conduct across all market participants.</li>
        </ul>
        
        <p style="text-align:center; color:rgb(187, 187, 187);">
            Enhancing Cross-Border Collaboration
        </p>
        <ul class="ps-3">
            <li>Building international regulatory partnerships and thought leadership across global capital markets.</li>
        </ul>
        
        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>Investor-Centric Approach</strong></span>
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            At the heart of our mandate lies a strong commitment to investor protection.
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            We strive to build confidence in the Malaysian capital market by:
        </p>
        <ul class="ps-3">
            <li>Enforcing fair and transparent practices</li>
            <li>Promoting financial literacy</li>
            <li>Enhancing public awareness of investment risks and rights</li>
        </ul>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            Through continuous oversight and innovation, the SC remains dedicated to building a capital market that is inclusive, future-ready, and aligned with global best practices.
        </p>

        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>Investor Protection</strong></span>
        </p>
        <p style="text-align:center; color:rgb(187, 187, 187);">
            Description of Project Partners<br>
            We work exclusively with top-tier project entities and financial institutions, selected through a stringent 360-degree due diligence process conducted prior to any engagement.<br>
            Each partnership undergoes:
        </p>
        <ul class="ps-3">
            <li>Comprehensive background checks</li>
            <li>Risk isolation protocols at the source</li>
            <li>Ongoing dynamic management and risk monitoring throughout the collaboration</li>
        </ul>
        <p style="text-align:center;">
            <span style="color:rgb(187, 187, 187);"><strong>A dedicated professional risk management team conducts full-cycle oversight of every investment target. By leveraging an advanced ecological risk control system, we provide users with a secure and reliable investment platform that ensures product safety from entry to exit.<br>
We only collect information relevant to operational efficiency and service delivery, maintaining the highest standards of data minimization and confidentiality.
Investor Identity Verification & Fund Security<br>
All investors must complete multi-layer security verifications prior to any financial transactions, including:</strong></span>
        </p>
        <ul class="ps-3">
            <li>Real-name identity verification</li>
            <li>Mobile device binding</li>
            <li>Bank account linkage (Funds can only be withdrawn to the verified bank account registered under the investor’s legal name)</li>
        </ul>
        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>To ensure financial transaction integrity:</strong></span>
        </p>
        <ul class="ps-3">
            <li>All fund transfers are subject to dual-control protocols, including designated personnel operations and independent audit review</li>
            <li>SSL 256-bit data encryption is employed for all sensitive operations (account login, deposits, withdrawals), ensuring end-to-end secure data transmission</li>
        </ul>
        <p style="text-align:center;">
            <span style="color:rgb(187, 187, 187);"><strong>Our institutional-grade safeguards are designed to eliminate vulnerabilities and guarantee the safety of investor assets at every stage.<br>
Privacy and SecurityWe are fully committed to protecting the confidentiality and integrity of user data.<br>
A robust internal security infrastructure ensures that unauthorized access—including from internal personnel—is strictly prohibited.<br>
Additional protection measures include:</strong></span>
        </p>
        <ul class="ps-3">
            <li>Information access controls</li>
            <li>Internal data audit trails</li>
            <li>Continuous monitoring against cyber threats</li>
        </ul>
        
        <p style="text-align:center;">
            <span style="color:rgb(187, 187, 187);"><strong>Before any investment is launched, the project undergoes rigorous evaluation and validation to ensure financial soundness, transparency, and operational viability—safeguarding every step of the investor’s capital journey.</strong><br>
</p><p style="text-align:center;">
    Legal Protection<br>
All investment projects on the platform are subject to comprehensive legal oversight, including:</span>
        </p>
        <ul class="ps-3">
            <li>Project establishment</li>
            <li>Legal due diligence and structuring</li>
            <li>Public offering compliance and documentation</li>
        </ul>
        <p style="text-align:center;">
            <span style="color:rgb(187, 187, 187);"><strong>Our in-house legal team, in conjunction with external regulatory advisors, ensures full alignment with Malaysian financial regulations and statutory policies.<br>
This guarantees that:</strong><br>
        </p>
        <ul class="ps-3">
            <li>All investor returns are legally binding and enforceable</li>
            <li>Projects meet compliance standards under the Capital Markets and Services Act (CMSA)</li>
            <li>Investors are protected by a transparent, law-abiding investment ecosystem</li>
        </ul>
        <p style="text-align:center;">
            <span style="color:rgb(187, 187, 187);"><strong>We continue to expand our project offerings under the framework of "Private Equity + Internet + Supervision", leveraging the strengths of digital finance while remaining under the strict purview of licensed public trust institutions.</strong></span>
        </p>

        <p>&nbsp;</p>
        <!-- Membership Level Description -->
        <p style="text-align:center;">
            <span style="color:rgb(0, 102, 204);"><strong>MEMBERSHIP LEVEL DESCRIPTION</strong></span>
        </p>
        <p>
            <span style="color:rgb(136, 136, 136); font-size:12px;">
                HLG Private Placement (HLGPP) is fully committed to providing high-quality financial investment services through a structured membership system. Each membership tier offers exclusive access to curated investment opportunities and premium benefits designed to reward commitment and participation.
            </span>
        </p>

        <p>&nbsp;</p>

        <!-- Ordinary Member -->
        <p class="mb-1">🔹 Ordinary Member</p>
        <ul class="list-unstyled p-0">
            <li>✅ Eligible to participate in projects below RM50,000</li>
            <li>✅ Membership validity: 12 calendar days</li>
            <li>✅ Entry-level access to foundational investment projects</li>
        </ul>
<br>
        <!-- Silver Member -->
        <p class="mb-1">
            🥈 Silver Member<br>
            <span style="color:rgb(230, 0, 0);"> Qualification: Total investment of RM50,000 within 24 hours</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>✅ Eligible to participate in projects between RM50,000 – RM100,000</li>
            <li>✅ No processing fees</li>
            <li>✅ Upgraded access to intermediate-tier projects</li>
            <li>✅ Enhanced support from platform representatives</li>
        </ul>
<br>
        <!-- Gold Member -->
        <p class="mb-1">
            🥇 Gold Member:<br>
            <span style="color:rgb(230, 0, 0);">Qualification: Total investment of RM100,000 within 24 hours</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>✅ Eligible to participate in projects between RM100,000 – RM500,000</li>
            <li>✅ No processing fees</li>
            <li>✅ No withdrawal fees</li>
            <li>✅ Eligible for multiple investment appointments</li>
            <li>✅ Priority access to limited-time offers and fast-closing opportunities</li>
        </ul>
<br>
        <!-- Platinum Member -->
        <p class="mb-1">
            💎 Platinum Member<br>
            <span style="color:rgb(230, 0, 0);"> Qualification: Total investment of RM500,000 within 24 hours</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>✅ Eligible to participate in projects between RM500,000 – RM1,000,000</li>
            <li>✅ No processing fees</li>
            <li>✅ No withdrawal fees</li>
            <li>✅ Eligible for multiple investment appointments</li>
            <li>✅ Exclusive invitation to the annual<br>“Singapore Fortune 500 Enterprise Exchange Conference”<br>
(Date to be advised by dedicated account personnel)</li>
            <li>✅ Entitled to use a 48-foot private yacht up to 3 times per year <br>(Up to 5 persons per session. Yacht access must be activated by submitting supporting documents to official representatives.)</li>
        </ul>
<br>
        <!-- Diamond Member -->
        <p class="mb-1">
            👑 Diamond Member<br>
            <span style="color:rgb(230, 0, 0);">Qualification: Total investment of RM1,000,000 within 24 hours</span>
        </p>
        <ul class="list-unstyled p-0">
            <li>✅ Eligible to participate in projects between RM1,000,000 – RM5,000,000</li>
            <li>✅ No processing fees</li>
            <li>✅ No withdrawal fees</li>
            <li>✅ Exclusive invitation to the annual<br>
“Singapore Fortune 500 Enterprise Exchange Conference”</li>
            <li>✅ Entitled to use a 48-foot private yacht up to 3 times per year</li>
            <li>✅ Annual entitlement to a 2-person private jet global flight experience<br>
(Access requires submission of relevant verification documents to official personnel.)</li>
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
@include('templates.header')
<div class="terms_condition">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="terms_condition-content">

                            <div class="terms_condition-text">
                                <h3 class="text-center" style="font-weight: bolder;">{{$pageName}}  </h3>
                                <p>Meritinfos LLC. and certain other Meritinfos group companies,
                                    collectively “{{$web->siteName}}”, operate the {{$web->siteName}} Network.</p>
                                    <p>
                                        To help government(s) fight the funding of terrorism and money laundering activities, various laws require {{$web->siteName}} and its affiliates to obtain, verify, and record information that identifies each person(s) who opens an account(s), or has
                                        a non-account relationship, or service agreement.
                                    </p>
                                    <p>
                                        To the extent that Merchants or Network Partners fail to provide or to consent to providing any such information, that failure shall be grounds for {{$web->siteName}} to not open an account, or enter into or a non-account relationship or service
                                        agreement. {{$web->siteName}} will close or terminate Merchant’s accounts, or sever a non-account relationship or service agreement, if {{$web->siteName}} or its Network Partner knows, suspects, or has reason to suspect that the relationship is causing or
                                        attempting to cause {{$web->siteName}} to:
                                    </p>
                                    <ul>
                                        <li>1. Transact in illicit activity;</li>
                                        <li>2. Transact activity with a Government(s) sanctioned person or vessel;</li>
                                        <li>3. Transact activity with a Government(s) sanctioned country;</li>
                                        <li>4. Fail to file a currency transaction report;</li>
                                        <li>5. Fail to file a report of international transportation of currency or monetary instruments;</li>
                                        <li>6. File an inaccurate and/or misleading report;</li>
                                        <li>7. Not to file a report or seize funds on an account; and</li>
                                        <li>8. Structure or attempt to structure large transactions into several smaller transactions in an attempt to avoid regulatory compliance reporting.</li>
                                    </ul>
                                    <p>
                                        Where Network Partners are subject to such laws in their Jurisdiction, Network Partners must implement and maintain an anti-money laundering / counter terrorist financing (“AML/CTF”) program, including policies, procedures, and controls
                                        that are reasonably designed to prevent the use of the {{$web->siteName}} Network to facilitate money laundering or the financing of terrorist activities.
                                    </p>
                                    <p>Such policies, procedures, and controls shall include, at a minimum:

                                            <ol >
                                                <li>1. Know Your Customer (KYC) programs,</li>
                                                <li>2. Sanctions screening against broadly accepted screening lists,</li>
                                                <li>3. Ongoing transaction monitoring and suspicious activity reporting programs, and</li>
                                                <li>4. Compliance with international best practices as set by FATF and other relevant organizations .</li>
                                            </ol>
                                        </p>
                                    <p>
                                        {{$web->siteName}} has exclusive authority to review such programs and their implementation in order to determine at any time whether a Network Partner is in compliance with these requirements, and to ensure that the implementation of these programs
                                        does not result in material changes or inconsistencies in the {{$web->siteName}} Network experience. Each Network Partner must cooperate with periodic reviews and any other efforts undertaken by {{$web->siteName}} to evaluate such Network Partners compliance
                                        with the AML/CTF requirements and the effects of program implementation on the {{$web->siteName}} Network experience. As part of a periodic review, {{$web->siteName}} may subject a Network Partner to enhanced due diligence (EDD) procedures which may include
                                        on-site examinations and/or the use of a third party reviewer. Any such examination is at the expense of the Network Partner, and a copy of the examination results must be provided promptly to {{$web->siteName}} upon request.
                                    </p>
                                    <p>
                                        In addition to KYC and AML/CTF programs executed by Network Partners, they must also provide {{$web->siteName}} with adequate transactional metadata to enable {{$web->siteName}} to effectively execute its own obligations for KYC, AML/CTF, Screening, and
                                        Transaction Monitoring. Where such data is not provided or is deemed by {{$web->siteName}} to be incomplete or insufficient, {{$web->siteName}} may block transactions or Partners or request additional data from a Network Partner.
                                    </p>
                                    <p>
                                        If {{$web->siteName}} determines that a Network Partner has failed to comply with these Network Rules, {{$web->siteName}} may impose conditions on or require additional actions of the Network Partner to prevent possible money laundering or financing of terrorist
                                        activities. These actions may include, but are not limited to, the following:
                                    </p>
                                    <ol>
                                        <li style="list-style-type: none;">
                                            <ol>
                                                <li style="list-style-type: none;">
                                                    <ol>
                                                        <li>1. Blocking or reversal of payment transactions and / or users;</li>
                                                        <li>2. Implementation of additional policies, procedures, or controls;</li>
                                                        <li>3. Termination of an agent agreement;</li>
                                                        <li>4. Termination of Network Partner in the {{$web->siteName}} ecosystem;</li>
                                                        <li>5. Non-compliance assessments; or</li>
                                                        <li>6. Other action that {{$web->siteName}} in its sole discretion determines to take with respect to the Network Partner or the Network Partner’s designated agent.</li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                    <p>
If you have any questions regarding this Privacy Policy, the practices of this site or your
interactions with this site, including requests to access personal information and/or correct
personal information, please contact us: <b>{{$web->siteSupportMail}}</b><br></p><br><b>
Last Edited: January 25, 2022 </b>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('templates.footer')

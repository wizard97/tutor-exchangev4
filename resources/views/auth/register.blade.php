<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>Register</h1>
  </div>

  @include('templates/feedback')
  <div class="col-md-6 well">
    <!-- register form -->
    {!! Form::open(['url' => '/auth/register']) !!}
    {!! csrf_field() !!}


    <div class="form-group">
      {!! Form::label('fname', 'First name') !!}
      {!! Form::text('fname', null, ['class' => 'form-control']) !!}
    </div>



    <div class="form-group">
      {!! Form::label('lname', 'Last name') !!}
      {!! Form::text('lname', null, ['class' => 'form-control']) !!}
    </div>


    <div class="form-group">
      {!! Form::label('email', 'Email') !!}
      {!! Form::email('email', null, ['class' => 'form-control']) !!}
      <p class="help-block">Please use a real email, you'll recieve an email with an activation link</p>
    </div>

    <div class="form-group">
      {!! Form::label('address', 'Address') !!}
      {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => '251 Waltham St, Lexington, MA 02421']) !!}
      <p class="help-block">This will be kept private, we only use it for our tutor search algorithm.</p>
    </div>

<!--
    <div class="form-group">
      {!! Form::label('zip', 'Zip Code') !!}
      {!! Form::text('zip', null, ['class' => 'form-control']) !!}
    </div>
-->

    <div class="form-group">
      {!! Form::label('password', 'Password') !!}
      {!! Form::password('password', ['class' => 'form-control']) !!}
      <p class="help-block">Minimum 6 characters</p>
    </div>
    <div class="form-group">
      {!! Form::label('password_confirmation', 'Repeat Password') !!}
      {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    </div>



    {!! Form::label('Account Type') !!}
    <br>
    <div class="btn-group" data-toggle="buttons">
      <label class="btn btn-primary @if (Input::old('account_type') == 1) active @endif">
        {!! Form::radio('account_type', '1') !!} Standard
      </label>
      <label class="btn btn-primary @if (Input::old('account_type') == 2) active @endif">
        {!! Form::radio('account_type', '2') !!} Tutor
      </label>
      <label class="btn btn-primary @if (Input::old('account_type') == 3) active @endif">
        {!! Form::radio('account_type', '3') !!} Professional Tutor
      </label>
    </div>
    <p class="help-block">Select "Search Only" if you are looking for a tutor, "Tutor" if you are a standard tutor, and "Professional Tutor" if tutoring is a legitimate job for you and you consider yourself to be a professional.</p>


    <div class="checkbox">
      <label>
        {!! Form::checkbox('terms_conditions', '1') !!} <p style="display:inline-block">I agree to the <a href="#" data-toggle="modal" data-target="#terms">Terms and Conditions</a> and the <a href="#" data-toggle="modal" data-target="#privacy">Privacy Policy</a>.<p>

          <div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h2 class="modal-title" id="myModalLabel">Terms and Conditions</h2>
                </div>
                <div class="modal-body">

                  <h3 id="1">Legal Notices</h3>
                  We, the Operators of lextutorexchange.com (the “Website”), provide it as a public service to our users.
                  Please carefully review the following basic rules that govern your use of the Website. Please note that your use of the Website constitutes your unconditional agreement to follow and be bound by these Terms and Use. If you (the "User") do not agree to them, do not use the Website, provide any materials to the Website or download any materials from the Website.
                  The Operators reserve the right to update or modify these Terms at any time without prior notice to User. Your use of the Website following any such change constitutes your unconditional agreement to follow and be bound by these Terms as changed. For this reason, we encourage you to review these Terms whenever you use the Website.
                  These Terms apply to the use of the Website and do not extend to any linked third party sites. These Terms and our Privacy Policy, which are hereby incorporated by reference, contain the entire agreement (the “Agreement”) between you and the Operators with respect to the Website. Any rights not expressly granted herein are reserved by the Operators.
                  <h3 id="2">Permitted and Prohibited Uses</h3>
                  You may use the the Website for the sole purpose of sharing and exchanging information with other Users. You may not use the the Website to violate any applicable local, state, national, or international law, including without limitation any applicable laws relating to antitrust or other illegal trade or business practices, federal and state securities laws, regulations promulgated by the U.S. Securities and Exchange Commission, any rules of any national or other securities exchange, and any U.S. laws, rules, and regulations governing the export and re-export of commodities or technical data.
                  You may not upload or transmit any material that infringes or misappropriates any person's copyright, patent, trademark, or trade secret, or disclose via the the Website any information the disclosure of which would constitute a violation of any confidentiality obligations you may have.
                  You may not upload any viruses, worms, Trojan horses, or other forms of harmful computer code, nor subject the Website's network or servers to unreasonable traffic loads, or otherwise engage in conduct deemed by the Operators to be disruptive to the ordinary operation of the Website.
                  You are strictly prohibited from communicating on or through the Website any unlawful, harmful, offensive, threatening, abusive, libelous, harassing, defamatory, vulgar, obscene, profane, hateful, fraudulent, sexually explicit, racially, ethnically, or otherwise objectionable material of any sort, including, but not limited to, any material that encourages conduct that would constitute a criminal offense, give rise to civil liability, or otherwise violate any applicable local, state, national, or international law.
                  You are expressly prohibited from compiling and using other Users' personal information, including addresses, telephone numbers, fax numbers, email addresses or other contact information that may appear on the Website, for the purpose of creating or compiling marketing and/or mailing lists and from sending other Users unsolicited marketing materials, whether by facsimile, email, or other technological means.
                  You also are expressly prohibited from distributing Users' personal information to third-party parties for marketing purposes. The Operators shall deem the compiling of marketing and mailing lists using Users' personal information, the sending of unsolicited marketing materials to Users, or the distribution of Users' personal information to third parties for marketing purposes as a material breach of these Terms, and the Operators reserve the right to terminate or suspend your access to and use of the Website and to suspend or revoke your membership in the consortium without refund of any membership dues paid.
                  The Operators note that unauthorized use of Users' personal information in connection with unsolicited marketing correspondence also may constitute violations of various state and federal anti-spam statutes. The Operators reserve the right to report the abuse of Users' personal information to the appropriate law enforcement and government authorities.
                  <h3 id="3">User Submissions</h3>
                  The Operators do not want to receive confidential or proprietary information from the Users through the Website. Any material, information, or other communication you transmit or post ("Contributions") to the Website will be considered non-confidential.
                  All contributions to this site are licensed by you under the MIT License to anyone who wishes to use them, including the Users and the Operators.
                  If you work for a company or at a University, it's likely that you're not the copyright holder of anything you make, even in your free time. Before making contributions to this site, get written permission from your employer.
                  <h3 id="4">User Discussion Lists and Forums</h3>
                  The Operators may, but are not obligated to, monitor or review any areas on the Website where users transmit or post communications or communicate with each other, including but not limited to user reviews, personal biographies, and the content of any such communications. The Operators, however, will have no liability related to the content of any such communications, whether or not arising under the laws of copyright, libel, privacy, obscenity, or otherwise. The Operators may edit or remove content on the the Website at their discretion at any time.
                  <h3 id="5">Use of Personally Identifiable Information</h3>
                  Information submitted to the Website is governed according to the Operators’s current Privacy Policy and the stated license of this website.
                  You agree to provide true, accurate, current, and complete information when registering with the Website. It is your responsibility to maintain and promptly update this account information to keep it true, accurate, current, and complete. If you provide any information that is fraudulent, untrue, inaccurate, incomplete, or not current, or we have reasonable grounds to suspect that such information is fraudulent, untrue, inaccurate, incomplete, or not current, we reserve the right to terminate or suspend your access to and use of the Website and to suspend or revoke your membership in the consortium without refund of any membership dues paid.
                  Although sections of the Website may be viewed simply by visiting the Website, in order to access some Content and/or additional features offered at the Website, you may need to sign on as a guest or register as a member. If you create an account on the Website, you may be asked to supply your name, address, a User ID and password. You are responsible for maintaining the confidentiality of the password and account and are fully responsible for all activities that occur in connection with your password or account. You agree to immediately notify us of any unauthorized use of your account or any other breach of security. You further agree that you will not permit others, including those whose accounts have been terminated, to access the Website using your account or User ID. You grant the Operators and all other persons or entities involved in the operation of the Website the right to transmit, monitor, retrieve, store, and use your information in connection with the operation of the Website and in the provision of services to you. The Operators cannot and do not assume any responsibility or liability for any information you submit, or your or third parties’ use or misuse of information transmitted or received using website. To learn more about how we protect the privacy of the personal information in your account, please visit our Privacy Policy.
                  <h3 id="6">Indemnification</h3>
                  You agree to defend, indemnify and hold harmless the Operators, agents, vendors or suppliers from and against any and all claims, damages, costs and expenses, including reasonable attorneys' fees, arising from or related to your use or misuse of the Website, including, without limitation, your violation of these Terms, the infringement by you, or any other subscriber or user of your account, of any intellectual property right or other right of any person or entity.
                  <h3 id="7">Termination</h3>
                  These Terms are effective until terminated by either party. If you no longer agree to be bound by these Terms, you must cease use of the Website. If you are dissatisfied with the Website, their content, or any of these terms, conditions, and policies, your sole legal remedy is to discontinue using the Website. The Operators reserve the right to terminate or suspend your access to and use of the Website, or parts of the Website, without notice, if we believe, in our sole discretion, that such use (i) is in violation of any applicable law; (ii) is harmful to our interests or the interests, including intellectual property or other rights, of another person or entity; or (iii) where the Operators have reason to believe that you are in violation of these Terms.
                  <h3 id="8">WARRANTY DISCLAIMER</h3>
                  THE WEBSITE AND ASSOCIATED MATERIALS ARE PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. TO THE FULL EXTENT PERMISSIBLE BY APPLICABLE LAW, THE OPERATORS DISCLAIM ALL WARRANTIES, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT OF INTELLECTUAL PROPERTY. THE OPERATORS MAKE NO REPRESENTATIONS OR WARRANTY THAT THE WEBSITE WILL MEET YOUR REQUIREMENTS, OR THAT YOUR USE OF THE WEBSITE WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR FREE; NOR DO THE OPERATORS MAKE ANY REPRESENTATION OR WARRANTY AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE WEBSITE. THE OPERATORS MAKE NO REPRESENTATIONS OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, AS TO THE OPERATION OF THE WEBSITE OR THE INFORMATION, CONTENT, MATERIALS, OR PRODUCTS INCLUDED ON THE WEBSITE.
                  IN NO EVENT SHALL THE OPERATORS OR ANY OF THEIR AGENTS, VENDORS OR SUPPLIERS BE LIABLE FOR ANY DAMAGES WHATSOEVER (INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOSS OF PROFITS, BUSINESS INTERRUPTION, LOSS OF INFORMATION) ARISING OUT OF THE USE OF, MISUSE OF, OR INABILITY TO USE THE WEBSITE, EVEN IF THE OPERATORS HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. THIS DISCLAIMER CONSTITUTES AN ESSENTIAL PART OF THIS AGREEMENT. BECAUSE SOME JURISDICTIONS PROHIBIT THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES, THE ABOVE LIMITATION MAY NOT APPLY TO YOU.
                  YOU UNDERSTAND AND AGREE THAT ANY CONTENT DOWNLOADED OR OTHERWISE OBTAINED THROUGH THE USE OF THE WEBSITE IS AT YOUR OWN DISCRETION AND RISK AND THAT YOU WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO YOUR COMPUTER SYSTEM OR LOSS OF DATA OR BUSINESS INTERRUPTION THAT RESULTS FROM THE DOWNLOAD OF CONTENT. THE OPERATORS SHALL NOT BE RESPONSIBLE FOR ANY LOSS OR DAMAGE CAUSED, OR ALLEGED TO HAVE BEEN CAUSED, DIRECTLY OR INDIRECTLY, BY THE INFORMATION OR IDEAS CONTAINED, SUGGESTED OR REFERENCED IN OR APPEARING ON THE WEBSITE. YOUR PARTICIPATION IN THE WEBSITE IS SOLELY AT YOUR OWN RISK. NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM THE OPERATORS OR THROUGH THE OPERATORS, THEIR EMPLOYEES, OR THIRD PARTIES SHALL CREATE ANY WARRANTY NOT EXPRESSLY MADE HEREIN. YOU ACKNOWLEDGE, BY YOUR USE OF THE THE WEBSITE, THAT YOUR USE OF THE WEBSITE IS AT YOUR SOLE RISK.
                  UNDER NO CIRCUMSTANCES AND UNDER NO LEGAL OR EQUITABLE THEORY, WHETHER IN TORT, CONTRACT, NEGLIGENCE, STRICT LIABILITY OR OTHERWISE, SHALL THE OPERATORS OR ANY OF THEIR AGENTS, VENDORS OR SUPPLIERS BE LIABLE TO USER OR TO ANY OTHER PERSON FOR ANY INDIRECT, SPECIAL, INCIDENTAL OR CONSEQUENTIAL LOSSES OR DAMAGES OF ANY NATURE ARISING OUT OF OR IN CONNECTION WITH THE USE OF OR INABILITY TO USE THE WEBSITE OR FOR ANY BREACH OF SECURITY ASSOCIATED WITH THE TRANSMISSION OF SENSITIVE INFORMATION THROUGH THE WEBSITE OR FOR ANY INFORMATION OBTAINED THROUGH THE WEBSITE, INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOST PROFITS, LOSS OF GOODWILL, LOSS OR CORRUPTION OF DATA, DISRUPTION OF WORK, ACCURACY OF RESULTS, OR COMPUTER FAILURE OR MALFUNCTION, EVEN IF AN AUTHORIZED REPRESENTATIVE OF THE OPERATORS HAS BEEN ADVISED OF OR SHOULD HAVE KNOWN OF THE POSSIBILITY OF SUCH DAMAGES.
                  THE OPERATORS'S TOTAL CUMULATIVE LIABILITY FOR ANY AND ALL CLAIMS IN CONNECTION WITH THE WEBSITE WILL NOT EXCEED FIVE U.S. DOLLARS ($5.00). USER AGREES AND ACKNOWLEDGES THAT THE FOREGOING LIMITATIONS ON LIABILITY ARE AN ESSENTIAL BASIS OF THE BARGAIN AND THAT THE OPERATORS WOULD NOT PROVIDE THE WEBSITE ABSENT SUCH LIMITATION.
                  <h3 id="9">General</h3>
                  The Website is hosted in the United States. The Operators make no claims that the Content on the Website is appropriate or may be downloaded outside of the United States. Access to the Content may not be legal by certain persons or in certain countries. If you access the Website from outside the United States, you do so at your own risk and are responsible for compliance with the laws of your jurisdiction. The provisions of the UN Convention on Contracts for the International Sale of Goods will not apply to these Terms. A party may give notice to the other party only in writing at that party's principal place of business, attention of that party's principal legal officer, or at such other address or by such other method as the party shall specify in writing. Notice shall be deemed given upon personal delivery or facsimile, or, if sent by certified mail with postage prepaid, 5 business days after the date of mailing, or, if sent by international overnight courier with postage prepaid, 7 business days after the date of mailing. If any provision herein is held to be unenforceable, the remaining provisions will continue in full force without being affected in any way. Further, the parties agree to replace such unenforceable provision with an enforceable provision that most closely approximates the intent and economic effect of the unenforceable provision. Section headings are for reference purposes only and do not define, limit, construe or describe the scope or extent of such section. The failure of the Operators to act with respect to a breach of this Agreement by you or others does not constitute a waiver and shall not limit the Operators's rights with respect to such breach or any subsequent breaches. Any action or proceeding arising out of or related to this Agreement or User's use of the Website must be brought in the courts of The United States of America, and you consent to the exclusive personal jurisdiction and venue of such courts. Any cause of action you may have with respect to your use of or inability to use the Website must be commenced within one (1) year after the claim or cause of action arises. These Terms set forth the entire understanding and agreement of the parties, and supersedes any and all oral or written agreements or understandings between the parties, as to their subject matter. The waiver of a breach of any provision of this Agreement shall not be construed as a waiver of any other or subsequent breach.
                  <h3 id="10">Links to Other Materials</h3>
                  The Website may contain links to sites owned or operated by independent third parties. These links are provided for your convenience and reference only. We do not control such sites and, therefore, we are not responsible for any content posted on these sites. The fact that the Operators offer such links should not be construed in any way as an endorsement, authorization, or sponsorship of that site, its content or the companies or products referenced therein, and the Operators reserve the right to note its lack of affiliation, sponsorship, or endorsement on the Website. If you decide to access any third party sites linked to by the Website, you do this entirely at your own risk. Because some sites employ automated search results or otherwise link you to sites containing information that may be deemed inappropriate or offensive, the Operators cannot be held responsible for the accuracy, copyright compliance, legality, or decency of material contained in third party sites, and you hereby irrevocably waive any claim against us with respect to such sites.
                  <h3 id="11">Notification Of Possible Copyright Infringement</h3>
                  In the event you believe that material or content published on the Website may infringe on your copyright or that of another, please contact us.
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="privacy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h2 class="modal-title" id="myModalLabel">Privacy Policy</h2>
            </div>
            <div class="modal-body">
              <h3>Privacy Policy</h3>
              We, the Operators of this Website, provide it as a public service to our users.
              Your privacy is important to us. Our goal is to provide you with a personalized online experience that provides you with the information, resources, and services that are most relevant and helpful to you. This Privacy Policy has been written to describe the conditions under which this web site is being made available to you. The Privacy Policy discusses, among other things, how data obtained during your visit to this web site may be collected and used. We strongly recommend that you read the Privacy Policy carefully. By using this web site, you agree to be bound by the terms of this Privacy Policy. If you do not accept the terms of the Privacy Policy, you are directed to discontinue accessing or otherwise using the web site or any materials obtained from it. If you are dissatisfied with the website, its Terms of Use, or its Privacy Policy, then by all means contact us; otherwise, your only recourse is to disconnect from this site and refrain from visiting the site in the future.
              The process of maintaining a web site is an evolving one, and the Operators may decide at some point in the future, without advance notice, to modify the terms of this Privacy Policy. Your use of the web site, or materials obtained from the web site, indicates your assent to the Privacy Policy at the time of such use. The effective Privacy Policy will be posted on the web site, and you should check upon every visit for any changes.
              <h3>Sites Covered by this Privacy Policy</h3>
              This Privacy Policy applies to all the Operators-maintained web sites, domains, information portals, and registries.
              Children’s Privacy
              The Operators are committed to protecting the privacy needs of children, and we encourage parents and guardians to take an active role in their children’s online activities and interests. The Operators do not intentionally collect information from minors.
              <h3>Links to Non-Operators Web Sites</h3>
              The Operators’s Website may provide links to third-party web sites for the convenience of our users. If you access those links, you will leave the Operators’s Website. The Operators do not control these third-party websites and cannot represent that their policies and practices will be consistent with this Privacy Policy. For example, other web sites may collect or use personal information about you in a manner different from that described in this document. Therefore, you should use other web sites with caution, and you do so at your own risk. We encourage you to review the privacy policy of any web site before submitting personal information.
              <h3>Types of Information We Collect</h3>
              Non-Personal Information</h3>
              Non-personal information is data about usage and service operation that is not directly associated with a specific personal identity. The Operators may collect and analyze non-personal information to evaluate how visitors use the Operators’s web sites.
              <h4>Aggregate Information</h4>
              The Operators may gather aggregate information, which refers to information your computer automatically provides to us and that cannot be tied back to you as a specific individual. Examples include referral data (the web sites you visited just before and just after our site), the pages viewed, time spent at our Website, and Internet Protocol (IP) addresses. An IP address is a number that is automatically assigned to your computer whenever you access the Internet. For example, when you request a page from one of our sites, our servers log your IP address to create aggregate reports on user demographics and traffic patterns and for purposes of system administration.
              <h4>Log Files</h4>
              Every time you request or download a file from the web site, the Operators may store data about these events and your IP address in a log file. The Operators may use this information to analyze trends, administer the website, track users’ movements, and gather broad demographic information for aggregate use or for other business purposes.
              <h4>Cookies</h4>
              Our site may use a feature of your browser to set a “cookie” on your computer. Cookies are small packets of information that a web site’s computer stores on your computer. The Operators’s web sites can then read the cookies whenever you visit our site. We may use cookies in a number of ways, such as to save your password so you don’t have to re-enter it each time you visit our site, to deliver content specific to your interests and to track the pages you’ve visited. These cookies allow us to use the information we collect to customize your experience so that your visit to our site is as relevant and as valuable to you as possible.
              Most browser software can be set up to deal with cookies. You may modify your browser preference to provide you with choices relating to cookies. You may have the choice to accept all cookies, to be notified when a cookie is set or to reject all cookies. If you choose to reject cookies, certain functions and conveniences of our web site may not work properly, and you may be unable to use those of the Operators’s services that require you to login in order to participate, or you will have to re-login each time you visit our site. Most browsers offer instructions on how to reset the browser to reject cookies in the “Help” section of the toolbar. We do not link non-personal information from cookies to personally identifiable information without your permission.
              <h4>Web Beacons</h4>
              The Operators’s web site also may use web beacons to collect non-personal information about your use of our web site and the web sites of selected sponsors or members, your use of special promotions or newsletters, and other activities. The information collected by web beacons allows us to statistically monitor how many people are using our web site and selected sponsors’ sites; how many people open our emails; and for what purposes these actions are being taken. Our web beacons are not used to track your activity outside of our web site or those of our sponsors. The Operators do not link non-personal information from web beacons to personally identifiable information without your permission.
              <h4>Personal Information</h4>
              Personal information is information that is associated with your name or personal identity. The Operators use personal information to better understand your needs and interests and to provide you with better service. On some of the Operators’s web pages, you may be able to request information, subscribe to mailing lists, participate in online discussions, provide feedback, submit information into registries, register for events, apply for membership, or join technical committees or working groups. The types of personal information you provide to us on these pages may include name, address, phone number, e-mail address, user IDs, passwords, billing information, or credit card information.
              <h4>Members-Only Web Sites</h4>
              Information you provide on Operators’s membership applications is used to create a member profile, and some information may be shared with other of the Operators’s individual member representatives and organizations. Member contact information may be provided to other members on a secure web site to encourage and facilitate collaboration, research, and the free exchange of information among the Operators’s members, but we expressly prohibit members from using member contact information to send unsolicited commercial correspondence. The Operators’s members may be automatically added to the Operators’s mailing lists. From time to time, member information may be shared with event organizers and/or other organizations that provide additional benefits to the Operators’s members. By providing us with your personal information on the membership application, you expressly consent to our storing, processing, and distributing your information for these purposes.
              <h3>How We Use Your Information</h3>
              The Operators may use non-personal data that is aggregated for reporting about the Operators’s web site usability, performance, and effectiveness. It may be used to improve the experience, usability, and content of the site.
              The Operators may use personal information to provide services that support the activities of the Operators’s members and their collaboration on the Operators’s standards and projects. When accessing the Operators’s members-only web pages, your personal user information may be tracked by the Operators in order to support collaboration, ensure authorized access, and enable communication between members.
              Credit card information may be collected to facilitate membership applications. Credit card numbers are used only for processing payment and are not used for other purposes. Payment processing services may be provided by a third-party payment service, and a management company external to the Operators may provide support for the financial activities of the Operators. the Operators may share your personal information with its partners to facilitate these transactions.
              <h3>Information Sharing</h3>
              The Operators does not sell, rent, or lease any individual’s personal information or lists of email addresses to anyone for marketing purposes, and we take commercially reasonable steps to maintain the security of this information. However, the Operators reserve the right to supply any such information to any organization into which the Operators may merge in the future or to which it may make any transfer in order to enable a third party to continue part or all of its mission. We also reserve the right to release personal information to protect our systems or business, when we reasonably believe you to be in violation of our Terms of Use or if we reasonably believe you to have initiated or participated in any illegal activity. In addition, please be aware that in certain circumstances, the Operators may be obligated to release your personal information pursuant to judicial or other government subpoenas, warrants, or other orders.
              In keeping with our open process, the Operators may maintain publicly accessible archives for the majority of our activities. For example, posting an email to any of the Operators’s-hosted public mail lists or discussion forums, subscribing to one of our newsletters or registering for one of our public meetings may result in your email address becoming part of the publicly accessible archives.
              On some sites, anonymous users are allowed to post content and/or participate in forum discussions. In such a case, since no user name can be associated with such a user, the IP address number of a user is used as an identifier. When posting content or messages to a Operators site anonymously, your IP address may be revealed to the public.
              If you are a registered member of an Operators's website or email list, you should be aware that some items of your personal information may be visible to other members and to the public. The Operators’s member databases may retain information about your name, e-mail address, company affiliation (if an organizational member), and such other personal address and identifying data as you choose to supply. That data may be visible to other of the Operators’s members and to the public. Your name, e-mail address, and other information you may supply also may be associated in the Operators’s publicly accessible records with the Operators’s various committees, working groups, and similar activities that you join, in various places, including: (i) the permanently-posted attendance and membership records of those activities; (ii) documents generated by the activity, which may be permanently archived; and, (iii) along with message content, in the permanent archives of the Operators’s e-mail lists, which also may be public.
              Please remember that any information (including personal information) that you disclose in public areas of our website, such as forums, message boards, and news groups, becomes public information that others may collect, circulate, and use. Because we cannot and do not control the acts of others, you should exercise caution when deciding to disclose information about yourself or others in public forums such as these.
              Given the international scope of the Operators websites, personal information may be visible to persons outside your country of residence, including to persons in countries that your own country’s privacy laws and regulations deem deficient in ensuring an adequate level of protection for such information. If you are unsure whether this Privacy Policy is in conflict with applicable local rules, you should not submit your information. If you are located within the European Union, you should note that your information will be transferred to the United States, which is deemed by the European Union to have inadequate data protection. Nevertheless, in accordance with local laws implementing European Union Directive 95/46/EC of 24 October 1995 (“EU Privacy Directive”) on the protection of individuals with regard to the processing of personal data and on the free movement of such data, individuals located in countries outside of the United States of America who submit personal information do thereby consent to the general use of such information as provided in this Privacy Policy and to its transfer to and/or storage in the United States of America.
              If you do not want your personal information collected and used by the Operators, please do not visit the Operators’s website or apply for membership of any of the Operators' websites or email lists.
              <h3>Access to and Accuracy of Member Information</h3>
              The Operators are committed to keeping the personal information of our members accurate. All the information you have submitted to us can be verified and changed. In order to do this, please email us a request. We may provide members with online access to their own personal profiles, enabling them to update or delete information at any time. To protect our members’ privacy and security, we also may take reasonable steps to verify identity, such as a user ID and password, before granting access to modify personal profile data. Certain areas of the Operators’s web sites may limit access to specific individuals through the use of passwords or other personal identifiers; a password prompt is your indication that a members-only resource is being accessed.
              <h3>Security</h3>
              The Operators make every effort to protect personal information by users of the web site, including using firewalls and other security measures on its servers. No server, however, is completely secure, and you should take this into account when submitting personal or confidential information about yourself on any website, including this one. Much of the personal information is used in conjunction with member services such as collaboration and discussion, so some types of personal information such as your name, company affiliation, and email address will be visible to other the Operators’s members and to the public. The Operators assume no liability for the interception, alteration, or misuse of the information you provide. You alone are responsible for maintaining the secrecy of your personal information. Please use care when you access this website and provide personal information.
              <h3>Opting Out</h3>
              From time to time the Operators may email you electronic newsletters, announcements, surveys or other information. If you prefer not to receive any or all of these communications, you may opt out by following the directions provided within the electronic newsletters and announcements.
              If you have questions regarding this privacy policy, please contact us.


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-lg btn-success">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Register
      </button>

      {!! Form::close() !!}
    </div>
  </div>
  @stop

<footer class="main-footer-1">
    <div class="container footer-inner">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="footer-item clearfix">
                    <img src="{{ asset($entreprise->LOGO ?? Help::$LOGO) }}" alt="logo" class="f-logo">
                    <div class="text">
                        <p class="mb-0">
                            {{$entreprise->DESCRIPTIF ?? 'Nous sommes est une institution financière dont la mission principale
                            est le financement de l’immobilier en Côte d’Ivoire. Nous nous sommes engagés
                            à faire du crédit immobilier souple et rentable une réalité pour d’innombrables hommes et femmes
                            en Côte d’Ivoire , ainsi que pour les constructeurs et promoteurs immobiliers.
                            Nous sommes IMMOBLIER-STORE, la Référence du Financement de l’immobilier !'}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item">
                    <h4>Nous Contactez</h4>
                    <ul class="contact-info">
                        <li>
                            <i class="flaticon-pin"></i>
                            {{$entreprise->ADRESSE ?? 'Abidjan, Plateau <br /> 01 BP 2325 Abidjan 01'}}
                        </li>
                        <li>
                            <i class="flaticon-mail"></i>
                            <a href="mailto:{{$entreprise->ADR_EMAIL ?? 'info@bhci.ci'}}">
                                {{$entreprise->ADR_EMAIL ?? 'info@bhci.ci'}}
                            </a>
                        </li>
                        <li>
                            <i class="flaticon-phone"></i>
                            <a href="tel:{{$entreprise->CONTACT1 ?? '+225 20 25 39 38'}}">
                                {{$entreprise->CONTACT1 ?? '+225 20 25 39 38'}} / {{$entreprise->CONTACT2 ?? ' 20 25 39 39'}}
                            </a>
                        </li>
                        <li>
                            <i class="flaticon-fax"></i>+225 20 22 58 18
                        </li>
                        <li hidden>
                            <i class="flaticon-internet"></i><a href="https://www.bhci.ci">bhci.ci</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="footer-item">
                    <h4>Liens Utiles </h4>
                    <ul class="links">
                        <li><a href="{{route('home')}}" class="link-inner"><span> Accueil</span></a></li>
                        <li><a href="{{route('listByCategories',['type'=>0, 'idCategories'=>0, 'act'=>'ls'])}}" class="link-inner"><span> Propriétes </span></a></li>
                        <li><a href="{{route('serviceOur')}}" class="link-inner"><span> Services</span></a></li>
                        <li><a href="{{route('aproposUs')}}" class="link-inner"><span> A Propos</span></a></li>
                        <li><a href="{{route('contactUs')}}" class="link-inner"><span> Nous Contactez</span></a></li>
                        @if(!isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR<=0)
                            <li><a href="{{route('cnxPage_A')}}" class="link-inner"><span> Connexion</span></a></li>
                        @else
                            <li><a href="{{route('deconnexion')}}" class="link-inner"><span> Deconnexion</span></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item clearfix">
                    <h4>Soucrire</h4>
                    <div class="Subscribe-box">
                        <p>Laissez nous votre email pour être informer sur toutes nos news</p>
                        <form class="form-inline d-flex" action="#">
                            <input class="form-control" type="email" id="email" placeholder="Email Address...">
                            <button class="btn btn-theme" type="submit"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <p class="copy"> © 2024 <a href="https://www.bmi.ci/">WFS-CI</a>. Tous droits Reservés. </p>
                </div>
                <div class="col-lg-4 col-md-12">
                    <ul class="social-list clearfix">
                        <li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="linkedin-bg"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="full-page-search">
    <button type="button" class="close">×</button>
    <form action="#">
        <input type="search" value="" placeholder="type keyword(s) here" />
        <button type="submit" class="btn btn-sm button-theme">Search</button>
    </form>
</div>

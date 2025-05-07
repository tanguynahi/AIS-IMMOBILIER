<div>

    @include('partials.manager.breadcrumb-nav', ['LBL' => $libel])

    <div class="tabbing tabbing-box mb-50 dashboard-list">

        @if (Help::optAutorise(['PAR' ,'ACC', 'ZZZ'], $iduscnx))
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @if (Help::optAutorise(['PAR', 'ZZZ'], $iduscnx))
            <li class="nav-item" role="presentation">
                <button class="nav-link @if ($compteopt==1) active @endif" id="home-tab" data-bs-toggle="tab"
                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                aria-selected="true" wire:click="optionSelect(1)">Paramètres</button>
            </li>
            @endif
            @if (Help::optAutorise(['ACC', 'ZZZ'], $iduscnx))
            <li class="nav-item" role="presentation">
                <button class="nav-link @if ($compteopt==2) active @endif" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                type="button" role="tab" aria-controls="profile"
                aria-selected="false" wire:click="optionSelect(2)">Compte utilisateur</button>
            </li>
            @endif
        </ul>
        <div class="tab-content" id="myTabContent">
            @if (Help::optAutorise(['PAR', 'ZZZ'], $iduscnx))
            <div class="tab-pane fade @if ($compteopt==1) show active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="accordion accordion-flush" id="accordionFlushExample7">
                    <div class="accordion-item">
                        @include('pages.manager.dataentreprise')
                    </div>
                </div>
            </div>
            @endif
            <div class="tab-pane fade @if ($compteopt==2) show active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="accordion accordion-flush" id="accordionFlushExample2">
                    <div class="accordion-item">
                        @include('pages.manager.accountus')
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

</div>

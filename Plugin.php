<?php
namespace SubsiteMuseusSwitcher;

use MapasCulturais\App;

class Plugin extends \MapasCulturais\Plugin {
    
    function __construct(array $config = [])
    {
        $config += [
            "main_site_id" => 1,
            "museu_site_id" => 3,
            "main_site_url" => 'https://www.mapacultural.pe.gov.br/',
            "museu_site_url" => 'https://www.museusdepernambuco.pe.gov.br/',
            "museu_site_create_url" => 'https://www.museusdepernambuco.pe.gov.br/painel/espacos/',
            "museu_plano_setorial_url" => 'https://docs.google.com/forms/d/1wP8K0H0RJEYclSF8EOtcxGOayEkpF-H0JLsW4HCm3YI/viewform?edit_requested=true',
        ];

        parent::__construct($config);
        
    }

    public function _init() {
        $app = App::i();

        $self = $this;

        $app->view->enqueueStyle('app', 'style-museus', 'css/style-museus.css');

        $app->hook("template(site.index.home-search-form):begin", function() use ($app, $self){
            $subsite_id = $app->getCurrentSubsiteId();
            if($subsite_id == $self->config['main_site_id']){
                $url = $self->config['museu_site_url'];
                $this->part("museus-switcher/switch-site", ["url" => $url]);
                
            }else if($subsite_id == $self->config['museu_site_id']){
                $main_site_url = $self->config['main_site_url'];
                $museu_site_create_url = $self->config['museu_site_create_url'];
                $museu_plano_setorial_url = $self->config['museu_plano_setorial_url'];

                // $this->part("museus-switcher/switch-museus", ["url" => $main_site_url]);
                $this->part("museus-switcher/switch-museus-create", [
                    "museu_site_create_url" => $museu_site_create_url, 
                    'plano_setorial_url' => $museu_plano_setorial_url, 
                    'main_site_url' => $main_site_url
                ]);

            }

        });

       

    }

    public function register() {
    }
}

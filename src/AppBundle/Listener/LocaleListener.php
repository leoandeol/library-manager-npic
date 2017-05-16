<?php
    namespace AppBundle\Listener;
    use Symfony\Component\HttpKernel\Event\GetResponseEvent;
    use Symfony\Component\HttpKernel\KernelEvents;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Symfony\Component\HttpFoundation\Session\Session;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    class LocaleListener implements EventSubscriberInterface
    {
        private $defaultLocale;
        private $locales;

    public function __construct(ContainerInterface $container, $availableOnes)
    {
	$defaultLocale='en';
	
       $this->locales = array( 'km'=>'km_KH',
                                'en'=>'en_GB,en_US',
                           );
        //default must exists in _locales array. locale_lookup Default: es_ES
        $this->defaultLocale = locale_lookup(array_keys($this->locales),
                                            $defaultLocale,
                                            false,
                                            current(explode(',',implode(',',array_values($this->locales)))));


    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();
	$locale = $request->getPreferredLanguage();
	if( $locale != "km" ){ $locale = "en"; }

        $this->setLocale($request, $session, $locale);
        return;
    }

    public function setLocale($request,$session,$locale)
    {
            //search language and lookup, default first locale in language
            if(in_array(current(locale_parse($locale)),array_keys($this->locales))){
                $locale = locale_lookup(explode(',',$this->locales[current(locale_parse($locale))]),
                                    $locale,
                                    false,
                                    current(explode(',',$this->locales[current(locale_parse($locale))])));
            }else{
                $locale = $this->defaultLocale;
            }

            //set session parameter
            if($locale!==$session->get('_locale')){
                $session->set('_locale',$locale);
                $session->set('language', current(locale_parse($locale)));//language code
            }
            //Set the default PHP locale.(for translations)
            $request->setLocale($locale);
            //set post parameter
            $request->request->set('_locale',$locale);  
            //set get parameter
            $request->query->set('_locale',$locale);  


            return;
    }

    static public function getSubscribedEvents()
    {
    return array(
        // must be registered before the default Locale listener
        KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
    );
    }

    }
    ?>
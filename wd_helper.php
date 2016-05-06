<?php
use Facebook\WebDriver as FbDriver;
use Facebook\WebDriver\Remote as FbRemote;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Net\URLChecker;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverExpectedCondition;

trait common_funcs{

    protected $driver;
    protected $Sdurl = 'the link you use';
    protected $Max_time = 1000;
    protected $Interval_time = 10;

    public function setUp()
    { 
        $host = 'http://localhost:4444/wd/hub';
        $options = new ChromeOptions();
        $options->addArguments(array('--disable-popup-blocking'));
        $caps = FbRemote\DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        $this->driver = FbRemote\RemoteWebDriver::create($host, $caps);
    }

    function mksure_stg($current_url = null){
        '''
        stagingページへ
        '''
        if(isset($current_url))
            self::till_urlIs($current_url);
        $URLchecker = new URLChecker;
        $url = $this->driver->getCurrentURL();
        if(!preg_match("/^(https:\/\/stg-)/", $url) && !preg_match("/^(https:\/\/stg.)/", $url))
        {
            try {
                $url = preg_replace('/^(https:\/\/)/', 'https://stg-', $url);
                if($URLchecker->waitUntilAvailable($this->Max_time, $url))
                {
                    $this->driver->get($url);
                    return ($this->driver->manage()->timeouts()->implicitlyWait = $this->Max_time); 
                }
            } catch (Exception $e) {
                ;
            }
            try {
                $url = preg_replace('/^(https:\/\/)/', 'https://stg.', $url);
                if($URLchecker->waitUntilAvailable($this->Max_time, $url))
                {
                    $this->driver->get($url);
                    return ($this->driver->manage()->timeouts()->implicitlyWait = $this->Max_time); 
                }
            } catch (Exception $e) {
                ;
            }
        }
        else
            return;

        return $this->driver->close();
    }

    function till_urlIs($url)
    {
        for ($i = 0;; $i++) {
            if($url == $this->driver->getCurrentURL() || $i > $this->Max_time)
                break;
        }
        if($i == $this->Max_time )
            return $this->driver->close();
    }

    function till_visual($target)
    {
        return WebDriverExpectedCondition::visibilityOfElementLocated($target);
    }

    function wait($title = null1, $pretitle = null2)
    {
        if($title !== $pretitle) return false;
        else return true;
    }

    function isAlertPresent($driver) 
    { 
        try 
        {
            $alert = $driver->switchTo()->alert(); 
        }
        catch (NoAlertPresentException $e){ 
            return false; 
        }
    }

    function choice_mechanism($mechanism = null, $element = null)
    {
        if($mechanism === 'Xpath')
            return WebDriverBy::Xpath($element);
        elseif ($mechanism === 'cssSelector')
            return WebDriverBy::cssSelector($element);
    }

    function click_element($mechanism = null, $element = null)
    {
        if(!isset($mechanism, $element))
            return false;
        $object = self::choice_mechanism($mechanism, $element);
        $this->driver->wait($this->Interval_time, $this->Max_time)->until(self::till_visual($object));
        $this->driver->findElement($object)->click();
    }

    function fill_form($mechanism = null, $element = null, $value = null)
    {
        if(!isset($mechanism, $element, $value))
            return false;
        $object = self::choice_mechanism($mechanism, $element);
        $this->driver->wait($this->Interval_time, $this->Max_time)->until(self::till_visual($object));
        $this->driver->findElement($object)->sendKeys($value);
    }

    function cast_a_spell($fillitems = null, $clickitems = null)
    {
        if(isset($fillitems))
            foreach($fillitems as $value)
                self::fill_form($value[0], $value[1], $value[2]);
        if(isset($clickitems))
            foreach($clickitems as $value)
                self::click_element($value[0], $value[1]);
    }

    function js_executor($element = null, $spell = null)
    {
        if(!isset($spell))
            return false;
        if (isset($element))
        {
            $object = self::choice_mechanism('cssSelector', $element);
            $this->driver->wait($this->Interval_time, $this->Max_time)->until(self::till_visual($object));
        }
        $this->driver->executeScript($spell);
    }
}
?>
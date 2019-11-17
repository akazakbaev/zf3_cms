<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 6/27/17
 * Time: 11:01 AM
 */
namespace Application\Service;

use Zend\I18n\Translator\Loader\RemoteLoaderInterface;
use Application\Entity\ApplicationTranslates;
use Application\Entity\ApplicationTranslateKey;

class DatabaseTranslationLoader implements RemoteLoaderInterface
{
    private $translates = array();

    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \Zend\Mvc\I18n\Translator
     */
    private $translator;

    /**
     * Filesystem cache.
     * @var \Zend\Cache\Storage\StorageInterface
     */
    private $cache;

    public function __construct($entityManager, $translator, $cache)
    {
        $this->translator = $translator;

        $this->entityManager = $entityManager;

        $this->cache = $cache;
    }

    public function removeTranslates()
    {
        $this->cache->removeItem('translates');
    }

    public function load($locale, $textDomain)
    {
        $locale = ($locale ?: $this->translator->getLocale());

        $this->loadTranslates();

        return isset($this->translates[$locale]) ? $this->translates[$locale] : [];
    }

    public function loadTranslates()
    {
        $data = $this->cache->getItem('translates');

        if( $data && is_array($data) )
        {
            $this->translates = $data;
            return;
        }

        $qb =$this->entityManager->createQueryBuilder();
        $query = $qb->from(ApplicationTranslateKey::class, 't1')
            ->select('t1.translateText, t2.translate, t2.locale')
            ->join('t1.translates', 't2')
            ->getQuery()
        ;

        $data = $query->getResult();

        $translates = array();

        foreach ($data as $row)
        {
            $translates[$row['locale']][$row['translateText']] = $row['translate'];
        }

        $this->translates = $translates;

        $this->_saveTranslates();
    }

    /**
     * @return \Zend\Mvc\I18n\Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    protected function _saveTranslates()
    {
        // Try to save to cache
        $this->cache->setItem('translates', $this->translates);
    }
}
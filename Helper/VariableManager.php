<?php

namespace Ecedi\VarsBundle\Helper;

use Ecedi\VarsBundle\Entity\Variable;

class VariableManager
{
    private $em;
    private $request;
    private $vars;

    public function __construct($em, $request)
    {
        $this->em = $em;
        $this->request = $request;
        $this->vars = $this->getVariables();
    }

    /**
     * Récupère le contenu d'une variable
     */
    public function get($name, $default = null)
    {
        return array_key_exists($name, $this->vars) ? $this->vars[$name]->getValue() : $default;
    }

    /**
     * Définit le contenu d'une variable
     */
    public function set($name, $value, $flush = true)
    {
        $variable = array_key_exists($name, $this->vars) ? $this->vars[$name] : new Variable($name);
        $variable->setValue($value);
        $variable->setDateUpdate(new \DateTime());
        $this->em->persist($variable);
    }

    /**
     * Récupère une variable
     */
    public function getVariable($name)
    {
        return array_key_exists($name, $this->vars) ? $this->vars[$name] : null;
    }

    /**
     * Peuple un tableau dont les clés sont des noms de variables avec
     * leurs valeurs respectives
     */
    public function populateDefaultValues(&$data)
    {
        // on récupère les variables stockées
        $variables = $this->em->createQuery('SELECT v FROM EcediVarsBundle:Variable v WHERE v.name IN (:names)')
            ->setParameter('names', array_keys($data))
            ->getResult();
        foreach ($variables as $variable) {
            $data[$variable->getName()] = $variable->getValue();
        }
    }

    /**
     * Traite la soumission d'un formulaire (de configuration) contenant
     * des champs correspondant à des variables.
     */
    public function process(&$form)
    {
        // on gère la requête
        if ($this->request->getMethod() == 'POST') {
            $form->bind($this->request);
            if ($form->isValid()) {
                $data = $form->getData();

                // on met à jour les variables
                foreach ($data as $name => $value) {
                    $this->set($name, $value, false);
                }
                $this->em->flush();

                return true;
            }
        }

        return false;
    }

    /**
     * Renvoie toutes les variables indexées dans un tableau
     */
    private function getVariables()
    {
        $variables = array();
        $query = $this->em->createQuery('SELECT v FROM EcediVarsBundle:Variable v');
        foreach ($query->getResult() as $variable) {
            $variables[$variable->getName()] = $variable;
        }

        return $variables;
    }

    /**
     * Renvoie toutes les variables sous forme de tableau associatif
     */
    private function getVariablesAssoc()
    {
        $variables = array();
        $query = $this->em->createQuery('SELECT v.name, v.value FROM EcediVarsBundle:Variable v');
        foreach ($query->getResult() as $result) {
            $variables[$result['name']] = $result['value'];
        }

        return $variables;
    }
}

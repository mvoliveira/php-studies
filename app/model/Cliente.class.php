<?php
class Cliente extends TRecord
{
    const TABLENAME = 'cliente';
    const PRIMARYKEY = 'codigo';
    const IDPOLICY = 'max';
    public function __construct($codigo = NULL)
    {
        parent::__construct($codigo);
        parent::addAttribute('codigo');
        parent::addAttribute('nome');
        parent::addAttribute('cpf');
        parent::addAttribute('rg');
        parent::addAttribute('endereço');
        parent::addAttribute('bairro');
        parent::addAttribute('numero');
        parent::addAttribute('complemento');
        parent::addAttribute('cep');
        parent::addAttribute('municipio');
        parent::addAttribute('estado');
        parent::addAttribute('email');
        parent::addAttribute('fone');
        parent::addAttribute('data_de_nascimento');
        parent::addAttribute('sexo');
        parent::addAttribute('estado_civil');
        parent::addAttribute('profissao');
        parent::addAttribute('naturalidade');

    }
}

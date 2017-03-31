<?php

class CursoList extends TStandardList
{

    protected $form;
    protected $datagrid;
    protected $pageNavigation;
    protected $formGrid;
    protected $deleteButton;

    public function __construct()
    {
        parent::__construct();

        //definindo banco de dados, tabela, e ordem dos dados
        parent::setDatabase('diario');
        parent::setActiveRecord('Curso');
        parent::setDefaultOrder('id', 'asc'); //order by id asc

        //definindo filtro do form buscar
        parent::addFilterField('id','=','id');
        parent::addFilterField('nome','like','nome');

        //criando form de busca/pesquisa de cursos
        $this->form = new BootstrapFormBuilder('form_search_curso');
        //titulo do form
        $this->form->setFormTitle('Cursos');
        //criar os campos do form de busca/pesquisa
        $nome = new TEntry('nome');//input type=text name=nome
        //adicionaod campo ao form
        $this->form->addFields([new TLabel('Nome')], [$nome]);
        //tamanho do campo no form
        $nome->setSize('70%');
        //manter os dados do form preenchido ao navegar/session
        $this->form->setData(TSession::getValue('Curso_filter_data'));

        //adicionando botoes ao form
        $this->form->addAction('Buscar', new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addAction('Novo', new TAction(array('CursoForm', 'onEdit')), 'bs:plus-sign green');


        //criando datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width:100%';
        $this->datagrid->setHeight(320);

        //criando colunas do datagrid(tabela)
        $column_id = new TDataGridColumn('id', 'ID', 'center', 50);
        $column_nome = new TDataGridColumn('nome', 'Nome', 'left', 50);
        $column_sigla = new TDataGridColumn('sigla', 'Sigla', 'left', 50);
        $column_desc = new TDataGridColumn('descricao', 'left', 'center', 50);

        //adicionando colunas ao datagrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_sigla);
        $this->datagrid->addColumn($column_desc);

        // criando datagrid model
        $this->datagrid->createModel();

        //criar container
        $container = new TVBox;
        $container->style = 'width:90%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid));
        //adicionar o datagrid(tabela/listagem dos cursos)


        //adicionar a paginacao

        parent::add($container);

    }//fim do método construct()

}

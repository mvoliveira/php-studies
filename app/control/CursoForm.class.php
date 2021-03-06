<?php

class CursoForm extends TStandardForm
{
    protected $form;

    public function __construct()
    {
        parent::__construct();

        //iniciar a construção do form para cadastrar curso
        //<form name='form_curso'>
        $this->form = new BootstrapFormBuilder('form_curso');
        $this->form->setFormTitle('Cadastro de Curso');

        //definir o banco de dados
        parent::setDatabase('diario');

        //definir a tabela
        parent::setActiveRecord('Curso');

        //criar os campos do formulário
        $id = new TEntry('id'); //<input type=text name=id
        $nome = new TEntry('nome');
        $sigla = new TEntry('sigla');
        $descricao = new TEntry('descricao');

        $id->setEditable('false');

        //adicionando os campos com label(rotulos)
        $this->form->addFields([new TLabel('ID')],[$id]);
        $this->form->addFields([new TLabel('Nome')],[$nome]);
        $this->form->addFields([new TLabel('Sigla')],[$sigla]);
        $this->form->addFields([new TLabel('Descrição')],[$descricao]);

        //definindo tamanho dos campos
        $id->setSize('30%');
        $nome->setSize('70%');
        $sigla->setSize('20%');
        $descricao->setSize('100%');

        //validação
        $nome->addValidation('Nome', new TRequiredValidator);
        $sigla->addValidation('Sigla', new TRequiredValidator);

        //add botoes salvar, editar e voltar para a listagem
        $this->form->addAction('Salvar', new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addAction('Editar', new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addAction('Voltar', new TAction(array('CursoList', 'onReload')), 'fa:table blue');

        //criar container(espaço) na tela
        $container = new TVBox;
        $container->style = 'width:90%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'CursoList'));

        //adiciona form ao container
        $container->add($this->form);

        //adicionar container a pagina
        parent::add($container);
    }

    public function onSave()
    {
        try
        {

            //abrindo conexão com o banco de dados
            TTransaction::open($this->database);

            //obtem dados do form
            $data = $this->form->getData();

            //cria objeto baseado na class Curso
            $object = new Curso;
            $object->id = $data->id;
            $object->nome = $data->nome;
            $object->sigla = $data->sigla;
            $object->descricao = $data->descricao;

            //salva objeto (registro) no banco/tabela
            $object->store();

            //obtem id gerado
            $data->id = $object->id;

            //popula os campos do form com os dados gravados
            $this->form->setData($data);

            //fecha conexão com o banco
            TTransaction::close();

            //mensagem para o usuário de curso cadastrado
            new TMessage('info', 'Curso cadastrado!');

            //retorna o objeto criado
            return $object;

        }
        catch(Exception $e)
        {
            //obter os dados do form
            $object = $this->form->getData($this->activeRecord);
            $this->form->setData($object);
            new TMessage('error', $e->getMessage());
            TTransaction::rollback;
        }
    }

    public function onEdit()
    {
        try
        {

            if(isset($param['key']))
            {
                $key = $param['key']
            }
            //abrindo conexão com o banco de dados
            TTransaction::open($this->database);

            $class = $this->activeRecord;
            $object = new $class($key);
            $object->controller = array($object->controller => $object->controller);
            $this->form->setData($object);

            //fecha conexão com o banco
            TTransaction::close();

            //mensagem para o usuário de curso cadastrado
            new TMessage('info', 'Curso cadastrado!');

            //retorna o objeto criado
            return $object;
        }else{
            $this->form->clear();
            }
        }
        catch(Exception $e)
        {
            //obter os dados do form
            $object = $this->form->getData($this->activeRecord);
            $this->form->setData($object);
            new TMessage('error', $e->getMessage());
            TTransaction::rollback;
        }
    }
}

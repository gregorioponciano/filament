<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Filament-v3-FFA116?style=for-the-badge&logo=laravel" alt="Filament v3">
  <img src="https://img.shields.io/badge/TALL_Stack-Pesh-blue?style=for-the-badge" alt="TALL Stack">
</p>

<h1 align="center">📊 Filament PHP Admin Panel Mastery</h1>

<p align="center">
  <strong>Exploração e implementação de painéis administrativos de alta performance utilizando Filament PHP (TALL Stack).</strong>
</p>

---

## 📝 Sobre o Projeto

Este repositório é dedicado ao estudo e implementação do **Filament**, uma coleção de componentes de interface para o framework Laravel. O foco aqui é demonstrar como construir sistemas de gestão (Backoffice) robustos, bonitos e extremamente rápidos.

### 🚀 Por que Filament?
O Filament utiliza a **TALL Stack** (Tailwind CSS, Alpine.js, Laravel e Livewire), permitindo criar interfaces reativas sem precisar sair do ecossistema PHP. É a ferramenta que utilizei para gerenciar o painel de controle de projetos como o **MarioBET**.

---

## ✨ Funcionalidades Exploradas

* **🛠️ Resource Management:** Criação automática de CRUDs (Create, Read, Update, Delete) com validações avançadas.
* **📈 Widgets & Dashboards:** Implementação de gráficos (Chart.js) e cartões de estatísticas em tempo real.
* **form Form Builder:** Construção de formulários complexos com campos de upload, seletores de data e relacionamentos.
* **📑 Table Builder:** Tabelas interativas com filtros, busca global, ações em lote e exportação de dados.
* **🔐 Multi-tenancy & Roles:** Gestão de níveis de acesso para administradores e usuários comuns.

---

## 💻 Exemplo de Recurso (Resource)

Abaixo, um exemplo de como defino um formulário de recurso no Filament:

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('nome')->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'ativo' => 'Ativo',
                    'inativo' => 'Inativo',
                ]),
            Forms\Components\FileUpload::make('foto')
                ->image()
                ->directory('produtos'),
        ]);
}

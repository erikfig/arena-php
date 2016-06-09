# ArenaPHP

Neste pequeno sistema usei parte das regras do jogo de mesa Daemon RPG (podia ser Dungeon & Dragons, mas eu não conheço bem as regras) para montar um simulador de luta para o console, não da pra fazer muitos combos, meio óbvio, mas você consegue montar seu lutador distribuindo pontos e ver como ele se sai contra um inimigo.

## Instalação

Para instalar faça o seguinte

 - [Baixe o projeto](https://github.com/erikfig/arena-php/archive/master.zip)
 - Descompacte o arquivo

## Como criar um lutador

Para criar um lutador rode o comando a seguir a partir da raiz do projeto.

    php battle.php fighter:create [nome] [força] [agilidade] [constituição]

As regras são:

 - O nome deve ser uma única palavra
 - O total de pontos distribuidos entre os 3 atributos (força, agilidade e constituição) devem ser iguais a 31
 - Você não pode colocar mais de 18 pontos em 1 único atributo
 - Você não pode colocar menos de 5 pontos em 1 único atributo

## Começar uma luta

Rode o comando a baixo:

    php battle.php battle:fight [rival]

Os rivais possíveis são **enemy1**, **enemy2**, **enemy3** e cada um tem os seguintes atributos:

    nome: Enemy 1
    força: 15
    agilidade: 8
    constituição: 7

    nome: Enemy 2
    força: 12
    agilidade: 15
    constituição: 11

    nome: Enemy 3
    força: 18
    agilidade: 18
    constituição: 18

## Para criar rivais

Crie um novo arquivo json dentro de `data/enemies` ou duplique um já existe e preencha seguindo esta estrutura:

    {"name":"nome","strength":força,"agility":agilidade,"constitution":constituição}

O nome do arquivo será usado para escolher este rival para batalha, por exemplo, um arquivo `data/enemies/ryu.json` se parecerá com:

    {"name":"Ryu","strength":17,"agility":19,"constitution":16}

E para lutar contra ele você usa no nome do arquivo sem a estensão, assim:

    php battle.php battle:fight ryu


## Porque você fez isso?

Para uma série de vídeos sobre Orientação a Objetos e TDD para iniciantes, o link vai ficar aqui quando estiver disponível.

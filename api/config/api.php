<?php

return [
    'header' => 'X-InbursaCockpit-Api-Key',
    'key' => env('API_KEY'),
    /*
     * Common
     */
    'common' => [
        'default-page-size' => 10,
    ],

    /*
     * Application errors
     */
    'errors' => [
        1 => 'Operação não realizada',
        14 => 'Usuário bloqueado!',

        // Auth
        400 => 'Erro na Validação',
        401 => 'Token expirado',
        402 => 'Token Inválido',
        403 => 'Acesso Negado',
        404 => 'Não Encontrado',
        405 => 'Usuário não encontrado',
        406 => 'Api Key inválida',
        407 => 'Usuário não verificado',
        410 => 'Token expirado. Uitilize a opção para reenviar token',
        411 => 'Senha não confere',
        412 => 'Método não permitido',
        413 => 'Método de chamada incorreto',
        414 => 'Email ou senha inválidos!',
        415 => 'Email não encontrado!',


        //CONECTION ERRORS
        2002 => 'MySql error',
        42 => 'Migração Pendente',

    ],

    /*
     * API error codes
     */
    'http-status-code' => [
        'user-blocked'                          => '14',
        'migracao-pendente'                     => '42',
        'success'                               => '200',
        'created'                               => '201',
        'no-content'                            => '204',
        'validation-error'                      => '400',
        'token-expired'                         => '401',
        'token-invalid'                         => '402',
        'access-denied'                         => '403',
        'not-found'                             => '404',
        'user-not-found'                        => '405',
        'invalid-api-key'                       => '406',
        'two-factor-expired'                    => '410',
        'password-not-match'                    => '411',
        'method-not-allowed'                    => '412',
        'bad-method-call'                       => '413',
        'invalid-credentials'                   => '414',
        'email-not-found'                       => '415',
        'supervisor-not-found'                  => '416',
        'inbursa-first-access-error'            => '417',
        'entity-not-found'                      => '418',
        'approve-user-corbam-denied'            => '419',
        'update-user-corbam-denied'             => '420',
        'visit-report-update-denied'            => '433',
        'visit-report-already-exists'           => '434',
        'visit-report-not-found'                => '435',
        'constraint-not-found'                  => '436',
        'product-already-exists'                => '437',
        'product-children-already-exists'       => '438',
        'formalization-type-already-exists'     => '439',
        'product-has-child'                     => '440',
        'product-deleted'                       => '441',
        'product-children-deleted'              => '442',
        'installment-not-match'                 => '443',
        'product-children-not-associate'        => '444',

        'internal-error'                        => '500',
        'send-email-fails'                      => '550',
        'send-event-external-fails'             => '551',
        'subsidiary-fee-not-found'              => '561',
        'entity-is-not-corban'                  => '562',
        'product-inactive'                      => '563',
        'proposal_not_found'                    => '567',
        'bank-agency-account-already-exists'    => '568',
        'legal-representative-not-found'        => '571',
    ],

    'middleware' => [
        'access-denied' => 'Usuário sem permissão de acesso!',
    ],

    'auth' => [
        'login-success' => 'Login realizado com sucesso!',
        'logout-success' => 'Logout realizado, TOKENS revogados com sucesso!',
        'refresh-success' => 'Token atualizado com sucesso!',
        'password-not-match' => 'Senha não confere!',
        'password-updated' => 'Senha atualizada!',
        'internal-error' => 'internal-error',
        'invalid-credentials' => 'Email ou senha inválidos!',
        'send-email-fails' => 'Falha no envio do email',
        'migracao-pendente' => 'Migração Pendente',
        'user-data' => 'Dados do Usuário Logado!',
        'validation-error' => 'Erro na Validação'
    ],

    'user' => [
        'create-success' => 'Usuário criado com sucesso!',
        'create-error' => 'Erro na criação do usuário!',
        'update-success' => 'Usuário atualizado com sucesso!',
        'update-error' => 'Usuário não pode ser atualizado!',
        'delete-success' => 'Usuário removido com sucesso!',
        'delete-error' => 'Usuário não pode ser removido!',
    ],
];

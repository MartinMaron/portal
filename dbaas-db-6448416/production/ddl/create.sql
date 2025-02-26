create table if not exists production.abrechnungssettings
(
    id                      bigint unsigned auto_increment
        primary key,
    realestate_id           bigint unsigned      null,
    bemerkung               varchar(500)         null,
    description             varchar(500)         null,
    nabi_inhaber            varchar(500)         null,
    nabi_nr                 varchar(50)          null,
    stromkosten             double     default 0 null,
    brenwert_gasabrechnug   tinyint(1) default 0 null,
    eigen_energielieferung  tinyint(1) default 0 null,
    OptimisticLockField     int                  null,
    created_at              timestamp            null,
    updated_at              timestamp            null,
    co2_kennzeichen_WEG     tinyint(1)           null,
    co2_wohngeb             tinyint(1)           null,
    co2_kennzeichen_1_9     tinyint(1)           null,
    co2_kennzeichen_2_9     tinyint(1)           null,
    co2_anschluss_nach_2022 tinyint(1)           null,
    periodFrom              date                 null,
    periodTo                date                 null,
    nutzerlisteDone         tinyint(1)           null,
    heizkostenlisteDone     tinyint(1)           null,
    betreibskostenDone      tinyint(1)           null,
    brennstofflisteDone     tinyint(1) default 0 null
)
    collate = utf8mb4_unicode_ci;

create index realestate_id
    on production.abrechnungssettings (realestate_id);

create table if not exists production.costinvoicingtypes
(
    id         varchar(191) unique
        primary key,
    caption    varchar(191) null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.costtypes
(
    id                   varchar(191) unique
        primary key,
    costinvoicingtype_id varchar(191) null,
    caption              varchar(191) null,
    sort                 int          null,
    created_at           timestamp    null,
    updated_at           timestamp    null,
    constraint costtypes_costinvoicingtype_id_foreign
        foreign key (costinvoicingtype_id) references production.costinvoicingtypes (id)
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.einheits
(
    id         int unsigned auto_increment
        primary key,
    caption    varchar(191) null,
    shortname  varchar(191) null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.failed_jobs
(
    id         int unsigned auto_increment
        primary key,
    uuid       varchar(191)                        null,
    connection text                                null,
    queue      text                                null,
    payload    longtext                            null,
    exception  longtext                            null,
    failed_at  timestamp default CURRENT_TIMESTAMP null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.fueltypes
(
    id         varchar(191) unique
        primary key,
    einheit_id int unsigned null,
    hasTank    tinyint(1)   null,
    caption    varchar(191) null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint fueltypes_einheit_id_foreign
        foreign key (einheit_id) references production.einheits (id)
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.lages
(
    id          int unsigned auto_increment
        primary key,
    bezeichnung varchar(191) null,
    created_at  timestamp    null,
    updated_at  timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(191) null,
    batch     int          null
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.password_resets
(
    id         int unsigned auto_increment
        primary key,
    email      varchar(191) null,
    token      varchar(191) null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create index password_resets_email_index
    on production.password_resets (email);

create table if not exists production.personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(191)    null,
    tokenable_id   bigint unsigned null,
    name           varchar(191)    null,
    token          varchar(64)     null,
    abilities      text            null,
    last_used_at   timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on production.personal_access_tokens (tokenable_type, tokenable_id);

create table if not exists production.realestates
(
    id                    bigint unsigned auto_increment
        primary key,
    user_id               int unsigned             null,
    nekoId                text                     null,
    address               text                     null,
    unvid                 text                     null,
    street                text                     null,
    postCode              text                     null,
    city                  text                     null,
    dateFrom              date                     null,
    dateTo                date                     null,
    dateStart             date                     null,
    heizkosten            tinyint(1)               null,
    rauchmelder           tinyint(1)               null,
    miete                 tinyint(1)               null,
    eingabeCostNetto      tinyint(1)   default 0   null,
    eingabeCostDatum      tinyint(1)   default 1   null,
    occupant_name_mode    tinyint(1)   default 0   null,
    occupant_number_mode  tinyint(1)   default 0   null,
    OptimisticLockField   int                      null,
    deleted_at            timestamp                null,
    created_at            timestamp                null,
    updated_at            timestamp                null,
    vorauszahlungen_mode  int          default 0   null,
    betriebskosten        tinyint(1)   default 0   null,
    kosteneingabe         tinyint(1)   default 0   null,
    abrechnungssetting_id bigint unsigned          null,
    prepaidtype           varchar(191) default 'H' null,
    nutzerlisteactive     tinyint(1)   default 0   null,
    uviactive             tinyint(1)   default 0   null,
    constraint realestates_abrechnungssetting_id_foreign
        foreign key (abrechnungssetting_id) references production.abrechnungssettings (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

alter table production.abrechnungssettings
    add constraint abrechnungssettings_ibfk_1
        foreign key (realestate_id) references production.realestates (id)
            on delete cascade;

create table if not exists production.costkeys
(
    id                  bigint unsigned auto_increment
        primary key,
    nekoKey_id          int        default 0 null,
    realestate_id       bigint unsigned      null,
    caption             varchar(500)         null,
    description         varchar(500)         null,
    zeitanteil          tinyint(1) default 0 null,
    einheit_id          int unsigned         null,
    viewText            varchar(191)         null,
    OptimisticLockField int                  null,
    created_at          timestamp            null,
    updated_at          timestamp            null,
    constraint costkeys_einheit_id_foreign
        foreign key (einheit_id) references production.einheits (id),
    constraint costkeys_ibfk_1
        foreign key (realestate_id) references production.realestates (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index realestate_id
    on production.costkeys (realestate_id);

create table if not exists production.costs
(
    id                   bigint unsigned auto_increment
        primary key,
    realestate_id        bigint unsigned      null,
    nekoId               int                  null,
    caption              varchar(191)         null,
    description          longtext             null,
    costtype_id          varchar(191)         null,
    fueltype_id          varchar(191)         null,
    startValue           double               null,
    startValueAmountNet  double               null,
    startValueAmountGros double               null,
    startValueAmountVat  double               null,
    endValue             double               null,
    haushaltsnah         tinyint(1)           null,
    co2Tax               tinyint(1) default 0 null,
    costkey_id           bigint unsigned      null,
    noticeForUser        text                 null,
    noticeForNeko        text                 null,
    consumption          tinyint(1) default 0 null,
    OptimisticLockField  int                  null,
    created_at           timestamp            null,
    updated_at           timestamp            null,
    prevyearPeriod       varchar(191)         null,
    prevyearQuantity     double               null,
    prevyearAmountnet    double               null,
    prevyearAmountgros   double               null,
    constraint costs_costtype_id_foreign
        foreign key (costtype_id) references production.costtypes (id),
    constraint costs_fueltype_id_foreign
        foreign key (fueltype_id) references production.fueltypes (id),
    constraint costs_ibfk_1
        foreign key (costkey_id) references production.costkeys (id)
            on delete set null,
    constraint costs_ibfk_2
        foreign key (realestate_id) references production.realestates (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.cost_amounts
(
    id                    bigint unsigned auto_increment
        primary key,
    cost_id               bigint unsigned default '0' null,
    nekoId                bigint unsigned default '0' null,
    bemerkung             varchar(191)                null,
    description           varchar(191)                null,
    netAmount             double                      null,
    grosAmount            double                      null,
    dateCostAmount        date                        null,
    consumption           double                      null,
    grosAmount_HH         double                      null,
    co2TaxValue           double                      null,
    OptimisticLockField   int                         null,
    created_at            timestamp                   null,
    updated_at            timestamp                   null,
    co2TaxAmount_gros     double                      null,
    co2TaxAmount_net      double                      null,
    abrechnungssetting_id bigint unsigned             null,
    startvalue            tinyint(1)                  null,
    endvalue              tinyint(1)                  null,
    constraint cost_amounts_cost_id_foreign
        foreign key (cost_id) references production.costs (id),
    constraint cost_amounts_ibfk_1
        foreign key (abrechnungssetting_id) references production.abrechnungssettings (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index abrechnungssetting_id
    on production.cost_amounts (abrechnungssetting_id);

create index costkey_id
    on production.costs (costkey_id);

create index realestate_id
    on production.costs (realestate_id);

create table if not exists production.invoices
(
    id                   bigint unsigned auto_increment
        primary key,
    createDate           date             null,
    caption              varchar(191)     null,
    description          varchar(191)     null,
    fileName             varchar(191)     null,
    realestate_id        bigint unsigned  null,
    nekoId               varchar(191)     null,
    dateFrom             date             null,
    dateTo               date             null,
    vertragsart          varchar(191)     null,
    bezahlt              tinyint(1)       null,
    bezahltAm            date             null,
    zahlungsAuftragDatum date             null,
    zahlungsauftragIBAN  varchar(191)     null,
    netto                double default 0 null,
    vat                  double default 0 null,
    brutto               double default 0 null,
    OptimisticLockField  int              null,
    created_at           timestamp        null,
    updated_at           timestamp        null,
    constraint invoices_ibfk_1
        foreign key (realestate_id) references production.realestates (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index realestate_id
    on production.invoices (realestate_id);

create table if not exists production.occupants
(
    id                   bigint unsigned auto_increment
        primary key,
    realestate_id        bigint unsigned      null,
    nekoId               varchar(40)          null,
    unvid                varchar(40)          null,
    budguid              varchar(40)          null,
    nutzeinheitNo        int unsigned         null,
    dateFrom             date                 null,
    dateTo               date                 null,
    anrede               varchar(191)         null,
    title                varchar(191)         null,
    nachname             varchar(191)         null,
    vorname              varchar(191)         null,
    street               varchar(191)         null,
    houseNr              varchar(191)         null,
    postcode             varchar(191)         null,
    city                 varchar(191)         null,
    address              text                 null,
    vat                  tinyint(1)           null,
    uaw                  tinyint(1)           null,
    qmkc                 double     default 0 null,
    qmww                 double     default 0 null,
    pe                   double     default 0 null,
    bemerkung            text                 null,
    vorauszahlung        double     default 0 null,
    lokalart             varchar(191)         null,
    customEinheitNo      varchar(191)         null,
    lage                 varchar(191)         null,
    email                varchar(191)         null,
    telephone_number     varchar(191)         null,
    eigentumer           varchar(191)         null,
    leerstand            tinyint(1) default 0 null,
    umlage_nutzerwechsel tinyint(1) default 1 null,
    OptimisticLockField  int        default 0 null,
    created_at           timestamp            null,
    updated_at           timestamp            null,
    vorauszahlungenBk    double     default 0 null,
    constraint occupants_ibfk_1
        foreign key (realestate_id) references production.realestates (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.livingareas
(
    id                    bigint unsigned auto_increment
        primary key,
    occupant_id           bigint unsigned             null,
    nekoId                bigint unsigned default '0' null,
    countvalue            double                      null,
    abrechnungssetting_id bigint unsigned             null,
    OptimisticLockField   int                         null,
    created_at            timestamp                   null,
    updated_at            timestamp                   null,
    constraint livingareas_abrechnungssetting_id_foreign
        foreign key (abrechnungssetting_id) references production.abrechnungssettings (id),
    constraint livingareas_occupant_id_foreign
        foreign key (occupant_id) references production.occupants (id)
)
    collate = utf8mb4_unicode_ci;

create index realestate_id
    on production.occupants (realestate_id);

create table if not exists production.personcounts
(
    id                    bigint unsigned auto_increment
        primary key,
    occupant_id           bigint unsigned             null,
    nekoId                bigint unsigned default '0' null,
    countvalue            double                      null,
    abrechnungssetting_id bigint unsigned             null,
    OptimisticLockField   int                         null,
    created_at            timestamp                   null,
    updated_at            timestamp                   null,
    constraint personcounts_ibfk_1
        foreign key (abrechnungssetting_id) references production.abrechnungssettings (id)
            on delete cascade,
    constraint personcounts_ibfk_2
        foreign key (occupant_id) references production.occupants (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index abrechnungssetting_id
    on production.personcounts (abrechnungssetting_id);

create index occupant_id
    on production.personcounts (occupant_id);

create table if not exists production.prepaids
(
    id                    bigint unsigned auto_increment
        primary key,
    occupant_id           bigint unsigned             null,
    nekoId                bigint unsigned default '0' null,
    netAmount             double                      null,
    grosAmount            double                      null,
    prepaidtype           varchar(191)    default 'H' null,
    abrechnungssetting_id bigint unsigned             null,
    OptimisticLockField   int                         null,
    created_at            timestamp                   null,
    updated_at            timestamp                   null,
    constraint prepaids_ibfk_1
        foreign key (abrechnungssetting_id) references production.abrechnungssettings (id)
            on delete cascade,
    constraint prepaids_ibfk_2
        foreign key (occupant_id) references production.occupants (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index abrechnungssetting_id
    on production.prepaids (abrechnungssetting_id);

create index occupant_id
    on production.prepaids (occupant_id);

create index realestates_user_id_index
    on production.realestates (user_id);

create table if not exists production.salutations
(
    id          int unsigned auto_increment
        primary key,
    bezeichnung varchar(191) null,
    created_at  timestamp    null,
    updated_at  timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.sessions
(
    id            varchar(191)    unique
        primary key,
    user_id       bigint unsigned null,
    ip_address    varchar(45)     null,
    user_agent    text            null,
    payload       text            null,
    last_activity int             null
)
    collate = utf8mb4_unicode_ci;

create index sessions_last_activity_index
    on production.sessions (last_activity);

create index sessions_user_id_index
    on production.sessions (user_id);

create table if not exists production.unit_usage_types
(
    type_id    varchar(191) null,
    caption    varchar(191) null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.users
(
    id                        int unsigned auto_increment
        primary key,
    name                      varchar(191)         null,
    email                     varchar(191)         null,
    email_verified_at         timestamp            null,
    password                  varchar(191)         null,
    two_factor_secret         text                 null,
    two_factor_recovery_codes text                 null,
    remember_token            varchar(100)         null,
    current_team_id           bigint unsigned      null,
    profile_photo_path        varchar(2048)        null,
    isAdmin                   tinyint(1) default 0 null,
    isUser                    tinyint(1) default 0 null,
    isMieter                  tinyint(1) default 0 null,
    apiToken                  varchar(191)         null,
    created_at                timestamp            null,
    updated_at                timestamp            null,
    createdFromWebForOccupant bigint unsigned      null,
    constraint users_email_unique
        unique (email),
    constraint users_createdfromwebforoccupant_foreign
        foreign key (createdFromWebForOccupant) references production.occupants (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.user_verbrauchsinfo_access_controls
(
    id                  bigint unsigned auto_increment
        primary key,
    occupant_id         bigint unsigned             null,
    user_id             int unsigned                null,
    neko_id             bigint unsigned default '0' null,
    jahr_monat          varchar(191)                null,
    toWebDelete         tinyint(1)                  null,
    OptimisticLockField int                         null,
    created_at          timestamp                   null,
    updated_at          timestamp                   null,
    constraint user_verbrauchsinfo_access_controls_occupant_id_foreign
        foreign key (occupant_id) references production.occupants (id)
            on delete cascade,
    constraint user_verbrauchsinfo_access_controls_user_id_foreign
        foreign key (user_id) references production.users (id)
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.verbrauchsinfo_counter_meters
(
    id                  bigint unsigned auto_increment
        primary key,
    occupant_id         bigint unsigned   null,
    nekoId              bigint unsigned   null,
    nr                  varchar(40)       null,
    funkNr              varchar(40)       null,
    art                 varchar(100)      null,
    einheit_id          int unsigned      null,
    nutzergrup_id       bigint unsigned   null,
    nutzergrup_name     varchar(150)      null,
    zeitraum_akt        varchar(21)       null,
    zeitraum_mon        varchar(21)       null,
    zeitraum_vorj       varchar(21)       null,
    verbrauch_akt       double default -1 null,
    verbrauch_mon       double default -1 null,
    verbrauch_vorj      double default -1 null,
    jahr_monat          varchar(191)      null,
    datum               date              null,
    stand_ende          double default -1 null,
    stand_anfang        double default -1 null,
    faktor              double default -1 null,
    hk                  tinyint(1)        null,
    ww                  tinyint(1)        null,
    OptimisticLockField int               null,
    created_at          timestamp         null,
    updated_at          timestamp         null,
    constraint verbrauchsinfo_counter_meters_einheit_id_foreign
        foreign key (einheit_id) references production.einheits (id),
    constraint verbrauchsinfo_counter_meters_occupant_id_foreign
        foreign key (occupant_id) references production.occupants (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.verbrauchsinfo_user_emails
(
    id                        bigint unsigned auto_increment
        primary key,
    realestate_id             bigint unsigned          null,
    nutzeinheitNo             int unsigned default '0' null,
    email                     varchar(255)             null,
    firstinitUsername         varchar(191)             null,
    OptimisticLockField       int                      null,
    createdFromWebForOccupant bigint unsigned          null,
    created_at                timestamp                null,
    updated_at                timestamp                null,
    occupant_id               bigint unsigned          null,
    anonym                    tinyint(1)   default 0   null,
    infoPerPortal             tinyint(1)   default 1   null,
    infoPerEmail              tinyint(1)   default 0   null,
    infoPerPost               tinyint(1)   default 0   null,
    constraint verbrauchsinfo_user_emails_createdfromwebforoccupant_foreign
        foreign key (createdFromWebForOccupant) references production.occupants (id)
            on delete cascade,
    constraint verbrauchsinfo_user_emails_occupant_id_foreign
        foreign key (occupant_id) references production.occupants (id)
            on delete cascade,
    constraint verbrauchsinfo_user_emails_realestate_id_foreign
        foreign key (realestate_id) references production.realestates (id)
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.verbrauchsinfos
(
    id                  bigint unsigned auto_increment
        primary key,
    occupant_id         bigint unsigned   null,
    art                 varchar(100)      null,
    einheit_id          int unsigned      null,
    nutzergrup_id       bigint unsigned   null,
    nutzergrup_name     varchar(150)      null,
    datum               date              null,
    zeitraum_akt        varchar(21)       null,
    zeitraum_mon        varchar(21)       null,
    zeitraum_vorj       varchar(21)       null,
    verbrauch_akt       double default -1 null,
    verbrauch_mon       double default -1 null,
    verbrauch_vorj      double default -1 null,
    hk                  tinyint(1)        null,
    ww                  tinyint(1)        null,
    durchschnitt        double default 0  null,
    jahr_monat          varchar(191)      null,
    OptimisticLockField int               null,
    created_at          timestamp         null,
    updated_at          timestamp         null,
    constraint verbrauchsinfos_einheit_id_foreign
        foreign key (einheit_id) references production.einheits (id),
    constraint verbrauchsinfos_occupant_id_foreign
        foreign key (occupant_id) references production.occupants (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table if not exists production.zaehler_arten
(
    id               int unsigned auto_increment
        primary key,
    art              varchar(191) null,
    caption          varchar(191) null,
    einheit_id       int unsigned null,
    sort_reihenfolge varchar(191) null,
    created_at       timestamp    null,
    updated_at       timestamp    null,
    constraint zaehler_arten_einheit_id_foreign
        foreign key (einheit_id) references production.einheits (id)
)
    collate = utf8mb4_unicode_ci;


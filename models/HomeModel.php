<?php
// /models/HomeModel.php

class HomeModel
{
    public function getData()
    {
        return [
            'title' => 'ArchivAI - Archivage Intelligent par IA',
            'hero' => [
                'title' => 'Archivage Intelligent Booster par<span> IA</span>',
                'text' => 'ArchivAI révolutionne la gestion documentaire avec une intelligence artificielle avancée qui classe, organise et sécurise  et <span>sauvegarde  dans votre CLOUD</span> vos fichiers automatiquement. Libérez-vous de la paperasse et concentrez-vous sur l\'essentiel.'
            ],
            'about' => [
                'title' => 'À propos d\'ArchivAI',
                'text' => 'Lancée en 2024, ArchivAI est une solution innovante développée en Côte d\'Ivoire qui répond aux défis de la gestion documentaire moderne. Notre technologie d\'IA de pointe transforme la façon dont les entreprises et les particuliers gèrent leurs documents, en offrant un système intelligent qui évolue avec vos besoins.',
                'vision' => 'Notre vision est de libérer les organisations des tâches répétitives de classement et d\'archivage pour leur permettre de se concentrer sur leur cœur de métier et leur croissance.',
                'image' => 'about-image.png'
            ],
            'features' => [
                'title' => 'Fonctionnalités Intelligentes',
                'subtitle' => 'Découvrez comment ArchivAI transforme votre expérience d\'archivage grâce à des technologies d\'IA avancées.',
                'items' => [
                    [
                        'icon' => 'fas fa-folder',
                        'title' => 'Classification Automatique',
                        'text' => 'Notre IA analyse le contenu de vos documents et les classe automatiquement selon vos catégories personnalisées. Réduisez de 95% le temps consacré au classement manuel.'
                    ],
                    [
                        'icon' => 'fas fa-search',
                        'title' => 'Reconnaissance Intelligente',
                        'text' => 'Extraction automatique des données clés (dates, montants, noms) grâce à notre technologie OCR avancée. Retrouvez n\'importe quelle information en quelques secondes.'
                    ],
                    [
                        'icon' => 'fas fa-shield-alt',
                        'title' => 'Sécurité Renforcée',
                        'text' => 'Cryptage de bout en bout et protection des données avec les standards les plus stricts de l\'industrie (ISO 27001, RGPD). Vos informations sensibles restent confidentielles.'
                    ],
                    [
                        'icon' => 'fas fa-sync',
                        'title' => 'Synchronisation Multi-Appareils',
                        'text' => 'Accédez à vos documents depuis n\'importe quel appareil, en ligne ou hors ligne. Modifications synchronisées automatiquement sur tous vos appareils.'
                    ],
                    [
                        'icon' => 'fas fa-chart-line',
                        'title' => 'Analyses et Rapports',
                        'text' => 'Suivez l\'utilisation de vos documents grâce à des tableaux de bord intuitifs et générez des rapports personnalisés pour optimiser votre workflow.'
                    ],
                    [
                        'icon' => 'fas fa-cogs',
                        'title' => 'Intégrations Flexibles',
                        'text' => 'Connectez ArchivAI à vos outils existants (Google Drive, Dropbox, MS Office) pour une transition sans effort et un écosystème digital unifié.'
                    ]
                ]
            ],
            'steps' => [
                'title' => 'Comment ça marche',
                'subtitle' => 'Notre processus en 4 étapes simples pour transformer votre gestion documentaire',
                'items' => [
                    [
                        'number' => 1,
                        'title' => 'Importez vos documents',
                        'text' => 'Téléchargez vos fichiers depuis votre ordinateur, votre cloud ou prenez-les en photo directement depuis votre mobile. Formats supportés : PDF, DOCX, JPG, PNG, Excel et plus encore.'
                    ],
                    [
                        'number' => 2,
                        'title' => 'Analyse par IA',
                        'text' => 'Notre intelligence artificielle traite le contenu, identifie le type de document et extrait les informations clés comme les dates, montants, et entités nommées.'
                    ],
                    [
                        'number' => 3,
                        'title' => 'Classement automatique',
                        'text' => 'Vos documents sont organisés selon vos règles et sauvegardés de manière sécurisée dans notre cloud. Créez vos propres catégories ou utilisez nos modèles prédéfinis.'
                    ],
                    [
                        'number' => 4,
                        'title' => 'Accès simplifié',
                        'text' => 'Retrouvez instantanément n\'importe quel document grâce à notre recherche intelligente et nos filtres avancés. Partagez en toute sécurité avec vos collaborateurs.'
                    ]
                ]
            ],
           
            'contact' => [
                'title' => 'Prêt à commencer ?',
                'text' => 'Notre équipe est à votre disposition pour répondre à toutes vos questions et vous accompagner dans votre transition vers une gestion documentaire intelligente. Contactez-nous dès aujourd\'hui pour une démonstration personnalisée.',
                'info' => [
                    [
                        'icon' => 'fas fa-phone-alt',
                        'text' => '+225 07 09 14 53 24'
                    ],
                    [
                        'icon' => 'fas fa-envelope',
                        'text' => 'koutoubilly@gmail.com'
                    ],
                    [
                        'icon' => 'fas fa-map-marker-alt',
                        'text' => 'Côte d\'Ivoire, Abidjan, Treichville, Im. SkyPark, 6ème étage'
                    ]
                ]
            ],
            'footer' => [
                'logo' => 'ArchivAI.png',
                'tagline' => 'La solution d\'archivage intelligent qui transforme votre gestion documentaire grâce à l\'intelligence artificielle.',
                'social' => [
                    [
                        'icon' => 'fab fa-facebook-f',
                        'link' => '#'
                    ],
                    [
                        'icon' => 'fab fa-twitter',
                        'link' => '#'
                    ],
                    [
                        'icon' => 'fab fa-instagram',
                        'link' => '#'
                    ],
                    [
                        'icon' => 'fab fa-linkedin-in',
                        'link' => '#'
                    ]
                ],
                'links' => [
                    [
                        'title' => 'Produit',
                        'items' => [
                            'Fonctionnalités',
                            'Tarification',
                            'Démo',
                            'Témoignages'
                        ]
                    ],
                    [
                        'title' => 'Entreprise',
                        'items' => [
                            'À propos',
                            'Carrières',
                            'Blog',
                            'Contact'
                        ]
                    ],
                    [
                        'title' => 'Ressources',
                        'items' => [
                            'Centre d\'aide',
                            'Documentation API',
                            'Tutoriels vidéo',
                            'Webinaires'
                        ]
                    ],
                    [
                        'title' => 'Légal',
                        'items' => [
                            'Conditions d\'utilisation',
                            'Politique de confidentialité',
                            'Mentions légales',
                            'RGPD'
                        ]
                    ]
                ]
            ]
        ];
    }
}
// Données simulées
const recentFiles = [
    { id: 1, name: 'Facture EDF.pdf', type: 'facture', date: '03/05/2025', tags: ['énergie', 'mensuel'], score: 98 },
    { id: 2, name: 'Carte Vitale.jpg', type: 'carte_identite', date: '01/05/2025', tags: ['santé'], score: 95 },
    { id: 3, name: 'Bulletin de paie.pdf', type: 'facture', date: '30/04/2025', tags: ['revenu'], score: 99 },
    { id: 4, name: 'Passeport.jpg', type: 'carte_identite', date: '28/04/2025', tags: ['voyage', 'identité'], score: 97 },
    { id: 5, name: 'Contrat de bail.pdf', type: 'contrat', date: '25/04/2025', tags: ['logement'], score: 94 }
];

// Configuration des couleurs pour le mode nuit
const getLightColors = () => {
    return {
        chartTextColor: '#1e293b',
        distributionColors: ['#3b82f6', '#ec4899', '#10b981'],
        activityColor: '#4f46e5',
        gridColor: '#e2e8f0'
    };
};

const getDarkColors = () => {
    return {
        chartTextColor: '#e2e8f0',
        distributionColors: ['#60a5fa', '#f472b6', '#34d399'],
        activityColor: '#818cf8',
        gridColor: '#334155'
    };
};

// Charts globaux pour pouvoir les mettre à jour
let fileDistributionChart, monthlyActivityChart;

// Initialisation des graphiques
const initCharts = () => {
    const isDarkMode = document.body.classList.contains('dark-mode');
    const colors = isDarkMode ? getDarkColors() : getLightColors();
    
    Chart.defaults.color = colors.chartTextColor;
    Chart.defaults.borderColor = colors.gridColor;
    
    // Détruire les graphiques existants s'ils existent
    if (fileDistributionChart) fileDistributionChart.destroy();
    if (monthlyActivityChart) monthlyActivityChart.destroy();
    
    // Distribution des fichiers
    const fileDistributionCtx = document.getElementById('fileDistributionChart').getContext('2d');
    fileDistributionChart = new Chart(fileDistributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Factures', 'Cartes d\'identité', 'Contrats'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: colors.distributionColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            cutout: '70%'
        }
    });

    // Activité mensuelle
    const monthlyActivityCtx = document.getElementById('monthlyActivityChart').getContext('2d');
    monthlyActivityChart = new Chart(monthlyActivityCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai'],
            datasets: [{
                label: 'Documents',
                data: [4, 7, 5, 8, 12],
                backgroundColor: colors.activityColor,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.gridColor
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
};

// Filtrage des fichiers
const filterFiles = (filterType, searchText = '') => {
    return recentFiles.filter(file => {
        const matchesFilter = filterType === 'tous' || file.type === filterType;
        const matchesSearch = file.name.toLowerCase().includes(searchText.toLowerCase());
        return matchesFilter && matchesSearch;
    });
};

// Affichage des fichiers
const renderFiles = (files) => {
    const container = document.getElementById('fileList');
    if (!container) return;
    
    const isDarkMode = document.body.classList.contains('dark-mode');
    const cardClass = isDarkMode ? 'bg-dark text-light' : 'bg-light';
    
    container.innerHTML = files.map(file => `
        <div class="col-md-6 col-lg-4">
            <div class="card ${cardClass} h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-${file.type === 'facture' ? 'invoice' : file.type === 'contrat' ? 'contract' : 'image'} me-3 fs-3 text-primary"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${file.name}</h6>
                            <small class="text-muted">${file.date}</small>
                            <div class="mt-2">${file.tags.map(tag => `
                                <span class="badge bg-info me-1">${tag}</span>
                            `).join('')}</div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <span class="badge bg-success">IA ${file.score}%</span>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
};

// Gestion du mode nuit
const toggleTheme = () => {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
    
    // Changer l'icône
    const themeBtns = document.querySelectorAll('.btn-toggle-theme');
    themeBtns.forEach(btn => {
        btn.innerHTML = document.body.classList.contains('dark-mode') 
            ? '<i class="fas fa-sun"></i>' 
            : '<i class="fas fa-moon"></i>';
    });
    
    // Mettre à jour les graphiques
    initCharts();
    
    // Mettre à jour la liste des fichiers
    renderFiles(recentFiles);
};

// Au chargement
document.addEventListener('DOMContentLoaded', () => {
    // Vérifier le mode enregistré
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark' && !document.body.classList.contains('dark-mode')) {
        document.body.classList.add('dark-mode');
    } else if (savedTheme === 'light' && document.body.classList.contains('dark-mode')) {
        document.body.classList.remove('dark-mode');
    }
    
    // Appliquer l'icône correcte selon le thème
    const themeBtns = document.querySelectorAll('.btn-toggle-theme');
    themeBtns.forEach(btn => {
        btn.innerHTML = document.body.classList.contains('dark-mode') 
            ? '<i class="fas fa-sun"></i>' 
            : '<i class="fas fa-moon"></i>';
    });
    
    // Ajouter les écouteurs d'événements pour les boutons de bascule
    document.querySelectorAll('.btn-toggle-theme').forEach(btn => {
        btn.addEventListener('click', toggleTheme);
    });

    // Initialisation des graphiques
    const fileDistributionChartEl = document.getElementById('fileDistributionChart');
    const monthlyActivityChartEl = document.getElementById('monthlyActivityChart');

    if (fileDistributionChartEl && monthlyActivityChartEl) {
        initCharts();
    } else {
        console.error('Les éléments du graphique ne sont pas trouvés.');
    }

    // Affichage des fichiers récents
    renderFiles(recentFiles);

    // Gestion de la recherche
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const filtered = filterFiles('tous', e.target.value);
            renderFiles(filtered);
        });
    }
    
    // Animation d'entrée pour la caméra flottante
    const floatingCamera = document.querySelector('.floating-camera');
    if (floatingCamera) {
        setTimeout(() => {
            floatingCamera.style.animation = 'fadeIn 0.5s ease-out forwards';
        }, 1000);
    }
});
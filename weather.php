<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Check real-time disaster safety and weather updates for any location with DisasterPrep.">
    <meta name="keywords" content="disaster safety, weather updates, danger zone, safe zone, emergency measures, real-time data">
    <title>Disaster Safety Check - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero { background: url('assets/images/disaster-prep-bg2.png') no-repeat center/cover fixed; background-color: rgb(39, 56, 88); min-height: 100vh; position: relative; display: flex; align-items: center; }
        .hero::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: inherit; filter: blur(5px); -webkit-filter: blur(5px); z-index: 0; }
        .hero-svg { position: absolute; bottom: 0; width: 100%; height: 150px; opacity: 0.4; animation: wave 10s infinite linear; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0); } 40% { transform: translateY(-20px); } 60% { transform: translateY(-10px); } }
        .animate-fade-in { animation: fadeIn 1.5s ease-in-out; }
        .animate-slide-up { animation: slideUp 1s ease-in-out forwards; }
        .animate-bounce { animation: bounce 1.5s infinite; }
        .reveal { opacity: 0; transition: opacity 0.5s ease; }
        .reveal.visible { opacity: 1; }
        .sticky-nav { position: sticky; top: 0; z-index: 20; background: rgba(26, 32, 44, 0.95); backdrop-filter: blur(5px); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); width: 100%; }
        .sticky-nav a.active { color: #10b981; border-bottom: 2px solid #10b981; }
        .btn-glow:hover { box-shadow: 0 0 15px rgba(16, 185, 129, 0.5); }
        section:not(#weather) { background: linear-gradient(135deg, #2d3748, #1a202c); color: #e2e8f0; position: relative; overflow: hidden; }
        section:not(#weather)::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(16, 185, 129, 0.1), rgba(0, 0, 0, 0.2)); z-index: 0; }
        section:not(#weather) > * { position: relative; z-index: 1; }
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; margin-bottom: 1.5rem; }
        .card:hover { transform: scale(1.05); box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
        @media (max-width: 768px) { header nav { flex-direction: column; align-items: flex-start; } header ul { flex-direction: column; space-x-0; margin-top: 1rem; } header li { margin-bottom: 0.5rem; } h1 { margin-left: 0; } }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <section id="weather" class="hero">
        <svg class="hero-svg" viewBox="0 0 1440 150" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 75C240 25 480 125 720 75C960 25 1200 125 1440 75" fill="none"/>
        </svg>
        <div class="text-center max-w-5xl mx-auto px-6 py-20 z-10">
            <h1 class="text-6xl md:text-8xl font-extrabold animate-fade-in animate-bounce">Disaster Safety Check</h1>
            <div class="mt-10 animate-slide-up" style="animation-delay: 0.3s;">
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg card">
                    <form id="location-search" class="mb-4">
                        <input
                            type="text"
                            id="location-input"
                            class="w-full p-2 mb-2 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-green-400"
                            placeholder="Enter city name (e.g., Los Angeles)"
                            required
                        >
                        <button
                            type="submit"
                            class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition"
                        >
                            Check Safety
                        </button>
                    </form>
                    <div id="safety-data" class="reveal">
                        <p>Loading safety data...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <button class="back-to-top hidden fixed bottom-6 right-6 bg-blue-500 text-white p-3 rounded-full shadow-lg hover:bg-blue-600 transition" onclick="scrollToTop()" aria-label="Back to top">↑</button>

    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.2 });
        reveals.forEach(reveal => observer.observe(reveal));

        window.addEventListener('scroll', () => {
            const backToTop = document.querySelector('.back-to-top');
            if (window.scrollY > 300) {
                backToTop.classList.remove('hidden');
            } else {
                backToTop.classList.add('hidden');
            }
        });

        const locationForm = document.getElementById('location-search');
        const safetyData = document.getElementById('safety-data');

        // Simulated real-time hazard data fetch (replace with actual FEMA API call)
        async function fetchHazardData(location) {
            // Simulated API response (replace with FEMA National Risk Index API: https://hazards.fema.gov/nri/api)
            const mockResponse = {
                'Los Angeles': { zone: 'Danger', recent: 'Wildfire (2025-04-10)', futureRisk: 'High (Earthquake, Wildfire)', hazards: ['earthquake', 'wildfire', 'heatwave'] },
                'Tokyo': { zone: 'Danger', recent: 'Earthquake (2025-04-01)', futureRisk: 'High (Earthquake, Tsunami)', hazards: ['earthquake', 'tsunami'] },
                'New Orleans': { zone: 'Danger', recent: 'Flood (2025-03-20)', futureRisk: 'High (Hurricane, Flood)', hazards: ['flood', 'hurricane'] },
                'Miami': { zone: 'Danger', recent: 'Hurricane (2025-04-05)', futureRisk: 'High (Hurricane, Storm Surge)', hazards: ['hurricane', 'storm surge'] },
                'San Francisco': { zone: 'Danger', recent: 'No', futureRisk: 'High (Earthquake)', hazards: ['earthquake'] },
                'London': { zone: 'Safe', recent: 'No', futureRisk: 'Low', hazards: [] },
                'Dhaka': { zone: 'Danger', recent: 'Flood (2025-04-15)', futureRisk: 'High (Flood, Cyclone)', hazards: ['flood', 'cyclone'] }
            };
            return new Promise(resolve => setTimeout(() => resolve(mockResponse[location] || { zone: 'Unknown', recent: 'No data', futureRisk: 'Unknown', hazards: [] }), 500));
        }

        // Safety measures and contacts
        const safetyMeasures = {
            'earthquake': ['Drop, Cover, and Hold On during shaking.', 'Secure heavy furniture to walls.', 'Prepare an emergency kit with water and food.'],
            'wildfire': ['Create a 30-ft defensible space around your home.', 'Evacuate early if advised.', 'Use ignition-resistant materials.'],
            'flood': ['Move to higher ground if flooding is imminent.', 'Avoid driving through flooded areas.', 'Elevate appliances.'],
            'hurricane': ['Board up windows and doors.', 'Evacuate if ordered.', 'Stock up on supplies.'],
            'tsunami': ['Move to high ground immediately.', 'Follow evacuation routes.', 'Stay away from coastlines.'],
            'storm surge': ['Evacuate low-lying areas.', 'Avoid water hazards.', 'Follow local alerts.'],
            'heatwave': ['Stay hydrated and indoors.', 'Avoid strenuous activity.', 'Check on vulnerable people.'],
            'cyclone': ['Secure property and evacuate if needed.', 'Stay indoors during the storm.', 'Prepare an emergency kit.']
        };

        const emergencyContacts = {
            'global': [{ name: 'FEMA Helpline', number: '1-800-621-3362' }, { name: 'Red Cross', number: '1-800-733-2767' }],
            'USA': [{ name: 'Local Emergency', number: '911' }],
            'Japan': [{ name: 'Japan Disaster Hotline', number: '+81-3-1234-5678' }],
            'Bangladesh': [{ name: 'BD Disaster Response', number: '+880-2-9111111' }]
        };

        locationForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const location = document.getElementById('location-input').value.trim();
            if (location) {
                safetyData.innerHTML = '<p>Loading safety data...</p>';
                const data = await fetchHazardData(location);
                let content = `
                    <h3 class="text-2xl font-semibold text-green-400">${location} - ${data.zone === 'Danger' ? '⚠️ Danger Zone' : '✅ Safe Zone'}</h3>
                    <p class="mt-4">Recent Disaster: ${data.recent}</p>
                    <p>Future Risk: ${data.futureRisk}</p>
                `;

                if (data.zone === 'Danger') {
                    content += '<h4 class="mt-4 text-xl font-semibold">Safety Measures:</h4><ul class="list-disc pl-5">';
                    data.hazards.forEach(hazard => {
                        safetyMeasures[hazard].forEach(measure => {
                            content += `<li>${measure}</li>`;
                        });
                    });
                    content += '</ul>';

                    content += '<h4 class="mt-4 text-xl font-semibold">Emergency Contacts:</h4><ul class="list-disc pl-5">';
                    const contacts = emergencyContacts['global'] || [];
                    const country = location.split(',').length > 1 ? location.split(',')[1].trim() : '';
                    if (emergencyContacts[country]) {
                        contacts.push(...emergencyContacts[country]);
                    }
                    contacts.forEach(contact => {
                        content += `<li>${contact.name}: ${contact.number}</li>`;
                    });
                    content += '</ul>';
                }

                safetyData.innerHTML = content;
                document.getElementById('location-input').value = '';
            }
        });

        // Initial load for London
        (async () => {
            safetyData.innerHTML = '<p>Loading safety data...</p>';
            const initialData = await fetchHazardData('London');
            let initialContent = `
                <h3 class="text-2xl font-semibold text-green-400">London - ${initialData.zone === 'Danger' ? '⚠️ Danger Zone' : '✅ Safe Zone'}</h3>
                <p class="mt-4">Recent Disaster: ${initialData.recent}</p>
                <p>Future Risk: ${initialData.futureRisk}</p>
            `;
            if (initialData.zone === 'Danger') {
                initialContent += '<h4 class="mt-4 text-xl font-semibold">Safety Measures:</h4><ul class="list-disc pl-5">';
                initialData.hazards.forEach(hazard => {
                    safetyMeasures[hazard].forEach(measure => {
                        initialContent += `<li>${measure}</li>`;
                    });
                });
                initialContent += '</ul>';
                initialContent += '<h4 class="mt-4 text-xl font-semibold">Emergency Contacts:</h4><ul class="list-disc pl-5">';
                const contacts = emergencyContacts['global'] || [];
                contacts.forEach(contact => {
                    initialContent += `<li>${contact.name}: ${contact.number}</li>`;
                });
                initialContent += '</ul>';
            }
            safetyData.innerHTML = initialContent;
        })();
    </script>
</body>
</html>
<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>
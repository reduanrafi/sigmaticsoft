@extends('website.layouts.master')

@section('extra-style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
<style>
    /* Premium World Cup Theme Styles */
    .wc-container {
        font-family: 'Outfit', sans-serif;
        background: linear-gradient(135deg, #0b0f19 0%, #111827 50%, #070a13 100%);
        color: #f3f4f6;
        min-height: 100vh;
        padding: 40px 15px;
        position: relative;
        overflow: hidden;
    }

    /* Ambient glow elements */
    .wc-glow-1 {
        position: absolute;
        top: 10%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%);
        pointer-events: none;
    }
    .wc-glow-2 {
        position: absolute;
        bottom: 10%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.12) 0%, rgba(236, 72, 153, 0) 70%);
        pointer-events: none;
    }

    /* Glassmorphism panels */
    .wc-glass-panel {
        background: rgba(17, 24, 39, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        padding: 30px;
        transition: all 0.3s ease;
    }

    .wc-title {
        font-weight: 900;
        background: linear-gradient(to right, #6366f1, #a855f7, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Form Styles */
    .wc-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #9ca3af;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .wc-input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
        transition: all 0.2s ease !important;
    }

    /* Force dropdown options to stay dark & visible on all systems */
    .wc-input option {
        background-color: #111827 !important;
        color: #ffffff !important;
    }

    .wc-input:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2) !important;
        background: rgba(255, 255, 255, 0.08) !important;
    }

    /* Score input spinners */
    .wc-score-input-box {
        max-width: 80px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 800;
    }

    /* Drop-zone file upload */
    .wc-upload-zone {
        border: 2px dashed rgba(99, 102, 241, 0.4);
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        background: rgba(99, 102, 241, 0.02);
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .wc-upload-zone:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.05);
    }

    .wc-upload-zone i {
        font-size: 2rem;
        color: #6366f1;
        margin-bottom: 10px;
    }

    /* Card Layout styles */
    .wc-card-wrapper {
        perspective: 1000px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .wc-canvas-card {
        width: 480px;
        height: 600px;
        background: #0f111a;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 30px;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .wc-card-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        opacity: 0.12;
        z-index: 1;
        transition: opacity 0.5s ease;
        filter: grayscale(15%) contrast(110%);
    }

    .wc-card-bg-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, 
            rgba(15, 17, 26, 0.85) 0%, 
            rgba(15, 17, 26, 0.5) 45%, 
            rgba(15, 17, 26, 0.95) 100%
        );
        z-index: 2;
    }

    .wc-card-accent-glow {
        position: absolute;
        top: -20%;
        left: -20%;
        width: 140%;
        height: 140%;
        background: radial-gradient(circle at top left, var(--team-glow, rgba(99, 102, 241, 0.15)) 0%, rgba(0,0,0,0) 60%);
        z-index: 2;
        pointer-events: none;
    }

    .wc-card-content {
        position: relative;
        z-index: 3;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Sporty Badge */
    .wc-card-badge {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 8px 12px;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
        color: #a855f7;
    }

    .wc-badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #a855f7;
        box-shadow: 0 0 8px #a855f7;
    }

    .wc-card-supporter {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 15px;
    }

    .wc-supporter-avatar {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        border: 2px solid #6366f1;
        object-fit: cover;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .wc-supporter-info h4 {
        font-weight: 800;
        font-size: 1.25rem;
        margin: 0;
        letter-spacing: -0.5px;
        color: #ffffff;
    }

    .wc-supporter-info p {
        font-size: 0.75rem;
        color: #9ca3af;
        margin: 0;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* VS Grid Display */
    .wc-card-vs-container {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 22px 18px;
        margin: 20px 0;
        text-align: center;
    }

    .wc-card-vs-header {
        font-size: 0.72rem;
        color: #a855f7;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }

    .wc-card-vs-teams-grid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 15px 0;
    }

    .wc-card-vs-team-block {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        width: 35%;
    }

    .wc-card-vs-flag {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .wc-card-vs-team-name {
        font-weight: 800;
        font-size: 0.9rem;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width: 100%;
    }

    /* Scoreboard */
    .wc-card-score-mid {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 30%;
    }

    .wc-card-score-digit {
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 10px;
        width: 42px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 900;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        text-shadow: 0 0 10px rgba(99, 102, 241, 0.6);
    }

    .wc-card-score-colon {
        font-size: 1.5rem;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.3);
    }

    .wc-card-vs-footer {
        font-size: 0.68rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        margin-top: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.04);
        padding-top: 10px;
    }

    /* Commentary Bubble */
    .wc-card-prediction {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(236, 72, 153, 0.12) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 14px 18px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .wc-card-prediction::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #6366f1, #ec4899);
    }

    .wc-predict-title {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 1px;
        color: #ec4899;
        margin-bottom: 4px;
    }

    .wc-predict-text {
        font-weight: 700;
        font-size: 1.02rem;
        line-height: 1.3;
        margin: 0;
        color: #ffffff;
    }

    .wc-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 12px;
    }

    .wc-brand-logo {
        font-weight: 800;
        font-size: 0.85rem;
        letter-spacing: -0.5px;
    }

    .wc-brand-logo span {
        color: #6366f1;
    }

    .wc-copyright {
        font-size: 0.65rem;
        color: #6b7280;
    }

    /* Action Buttons */
    .btn-wc-primary {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-wc-primary:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
    }

    .btn-wc-facebook {
        background-color: #1877f2;
        border: none;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
    }

    .btn-wc-facebook:hover {
        background-color: #166fe5;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(24, 119, 242, 0.4);
    }

    /* Toast */
    .wc-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: rgba(17, 24, 39, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 12px;
        padding: 16px 20px;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 9999;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .wc-toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    .wc-toast i {
        color: #10b981;
        font-size: 1.25rem;
    }
</style>
@endsection

@section('content')
<div class="wc-container position-relative">
    <div class="wc-glow-1"></div>
    <div class="wc-glow-2"></div>

    <div class="container py-4">
        <!-- Page Header -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <div class="d-inline-flex align-items-center gap-2 mb-2 px-3 py-1 bg-dark bg-opacity-50 border border-secondary border-opacity-25 rounded-pill text-white-50">
                    <i class="fa-solid fa-trophy text-warning"></i>
                    <span class="fs-7 fw-semibold text-uppercase tracking-wider">World Cup 2026 Predictor</span>
                </div>
                <h1 class="display-4 fw-bolder wc-title mb-3">2026 Championship Match Predictor</h1>
                <p class="lead text-secondary mx-auto" style="max-width: 600px;">
                    Simulate the World Cup 2026! Predict real scheduled openers and finals, or design a custom dream matchup in the 16 host cities of USA, Canada, and Mexico!
                </p>
            </div>
        </div>

        <div class="row g-4 align-items-start">
            <!-- Left Panel: Control Form -->
            <div class="col-12 col-xl-6">
                <div class="wc-glass-panel">
                    <h3 class="fw-bold mb-4 d-flex align-items-center gap-2 text-white">
                        <i class="fa-solid fa-sliders text-indigo"></i> Customize Prediction
                    </h3>
                    
                    <form id="cardForm" onsubmit="event.preventDefault();">
                        <!-- 1. Select Supported Country -->
                        <div class="mb-4">
                            <label for="teamSelect" class="wc-label">1. Your Supported Team</label>
                            <select id="teamSelect" class="form-select wc-input">
                                <option value="" disabled selected>-- Select Your Supported Team --</option>
                                <option value="ARG">Argentina 🇦🇷</option>
                                <option value="BRA">Brazil 🇧🇷</option>
                                <option value="FRA">France 🇫🇷</option>
                                <option value="POR">Portugal 🇵🇹</option>
                                <option value="GER">Germany 🇩🇪</option>
                                <option value="ESP">Spain 🇪🇸</option>
                                <option value="ENG">England 🏴󠁧󠁢󠁥󠁮󠁧󠁿</option>
                                <option value="NED">Netherlands 🇳🇱</option>
                                <option value="BEL">Belgium 🇧🇪</option>
                                <option value="CRO">Croatia 🇭🇷</option>
                                <option value="URU">Uruguay 🇺🇾</option>
                                <option value="USA">United States 🇺🇸</option>
                                <option value="CAN">Canada 🇨🇦</option>
                                <option value="MEX">Mexico 🇲🇽</option>
                                <option value="JPN">Japan 🇯🇵</option>
                                <option value="KOR">South Korea 🇰🇷</option>
                                <option value="SEN">Senegal 🇸🇳</option>
                                <option value="MAR">Morocco 🇲🇦</option>
                                <option value="SUI">Switzerland 🇨🇭</option>
                                <option value="CMR">Cameroon 🇨🇲</option>
                                <option value="GHA">Ghana 🇬🇭</option>
                                <option value="TUN">Tunisia 🇹🇳</option>
                                <option value="DEN">Denmark 🇩🇰</option>
                                <option value="POL">Poland 🇵🇱</option>
                                <option value="AUS">Australia 🇦🇺</option>
                                <option value="KSA">Saudi Arabia 🇸🇦</option>
                                <option value="IRN">Iran 🇮🇷</option>
                                <option value="CRC">Costa Rica 🇨🇷</option>
                                <option value="ECU">Ecuador 🇪🇨</option>
                                <option value="WAL">Wales 🏴󠁧󠁢󠁬󠁳󠁿</option>
                                <option value="SRB">Serbia 🇷🇸</option>
                                <option value="QAT">Qatar 🇶🇦</option>
                            </select>
                        </div>

                        <!-- 1.5 Custom Match Toggle -->
                        <div class="mb-4 d-none" id="matchModeContainer">
                            <div class="wc-glass-panel p-3 border-secondary border-opacity-10 d-flex align-items-center justify-content-between" style="background: rgba(255,255,255,0.02); border-radius: 14px;">
                                <div>
                                    <label class="wc-label mb-0 cursor-pointer text-white d-flex align-items-center gap-2" for="customMatchToggle" style="font-size: 0.85rem; font-weight: 700;">
                                        <i class="fa-solid fa-wand-magic-sparkles text-indigo"></i> Enable Custom Dream Matchup
                                    </label>
                                    <span class="text-secondary small d-block mt-1" id="matchModeInfo" style="font-size: 0.72rem;">
                                        Show only official scheduled matches for your team.
                                    </span>
                                </div>
                                <div class="form-check form-switch m-0 p-0">
                                    <input class="form-check-input" type="checkbox" id="customMatchToggle" style="width: 2.5em; height: 1.25em; cursor: pointer; float: right; margin-left: 0;">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Select Opponent -->
                        <div class="mb-4 d-none" id="opponentSelectGroup">
                            <label for="opponentSelect" class="wc-label">2. Select Opponent / Matchup</label>
                            <select id="opponentSelect" class="form-select wc-input">
                                <option value="" disabled selected>-- Select Opponent --</option>
                            </select>
                        </div>

                        <!-- 2b. Dynamic Custom Dream Match Fields (Revealed ONLY if custom opponent selected) -->
                        <div class="d-none" id="customMatchFields">

                            <!-- Custom Stadium -->
                            <div class="mb-4">
                                <label for="customStadium" class="wc-label">Select 2026 Host Stadium</label>
                                <select id="customStadium" class="form-select wc-input">
                                    <option value="MetLife Stadium" selected>MetLife Stadium, New York / New Jersey</option>
                                    <option value="SoFi Stadium">SoFi Stadium, Los Angeles</option>
                                    <option value="Estadio Azteca">Estadio Azteca, Mexico City</option>
                                    <option value="BMO Field">BMO Field, Toronto</option>
                                    <option value="AT&T Stadium">AT&T Stadium, Dallas</option>
                                    <option value="Mercedes-Benz Stadium">Mercedes-Benz Stadium, Atlanta</option>
                                    <option value="Hard Rock Stadium">Hard Rock Stadium, Miami</option>
                                    <option value="BC Place">BC Place, Vancouver</option>
                                    <option value="Levi's Stadium">Levi's Stadium, San Francisco</option>
                                    <option value="Lumen Field">Lumen Field, Seattle</option>
                                    <option value="NRG Stadium">NRG Stadium, Houston</option>
                                    <option value="Lincoln Financial Field">Lincoln Financial Field, Philadelphia</option>
                                    <option value="Arrowhead Stadium">Arrowhead Stadium, Kansas City</option>
                                    <option value="Gillette Stadium">Gillette Stadium, Boston</option>
                                    <option value="Estadio Akron">Estadio Akron, Guadalajara</option>
                                    <option value="Estadio BBVA">Estadio BBVA, Monterrey</option>
                                </select>
                            </div>

                            <!-- Custom Stage -->
                            <div class="mb-4">
                                <label for="customStage" class="wc-label">Match Stage</label>
                                <select id="customStage" class="form-select wc-input">
                                    <option value="Group Stage" selected>Group Stage Match</option>
                                    <option value="Round of 32">Round of 32 Match</option>
                                    <option value="Round of 16">Round of 16 Match</option>
                                    <option value="Quarter-final">Quarter-final Match</option>
                                    <option value="Semi-final">Semi-final Match</option>
                                    <option value="World Cup Final">World Cup Final</option>
                                </select>
                            </div>
                        </div>

                        <!-- 3. Score Predictor -->
                        <div class="mb-4 d-none" id="scoreInputsGroup">
                            <label class="wc-label">3. Predict Scoreline</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-grow-1 text-center bg-dark bg-opacity-25 p-2 rounded-3 border border-secondary border-opacity-10">
                                    <span class="small text-secondary d-block mb-1" id="homeScoreLabel" style="font-weight:700; font-size: 0.75rem;">Home Team</span>
                                    <input type="number" id="homeScoreInput" class="form-control wc-input text-center fw-bold wc-score-input-box mx-auto" min="0" max="99" value="0">
                                </div>
                                <div class="fw-bold fs-3 text-secondary mt-3">:</div>
                                <div class="flex-grow-1 text-center bg-dark bg-opacity-25 p-2 rounded-3 border border-secondary border-opacity-10">
                                    <span class="small text-secondary d-block mb-1" id="awayScoreLabel" style="font-weight:700; font-size: 0.75rem;">Away Team</span>
                                    <input type="number" id="awayScoreInput" class="form-control wc-input text-center fw-bold wc-score-input-box mx-auto" min="0" max="99" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- 4. Supporter Name -->
                        <div class="mb-4">
                            <label for="supporterName" class="wc-label">4. Your Name</label>
                            <input type="text" id="supporterName" class="form-control wc-input" placeholder="e.g. Reduan Rafi" maxlength="25">
                        </div>

                        <!-- 5. Prediction Text -->
                        <div class="mb-4">
                            <label for="predictionText" class="wc-label">5. Supporter Comments</label>
                            <textarea id="predictionText" class="form-control wc-input" rows="2" placeholder="e.g. Messi will score a brilliant goal in the second half!" maxlength="100"></textarea>
                        </div>

                        <!-- 6. Supporter Photo Upload -->
                        <div class="mb-4">
                            <label class="wc-label">6. Upload Supporter Photo (Privacy Secured)</label>
                            <div class="wc-upload-zone" id="dropZone" onclick="document.getElementById('photoInput').click()">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <h6 class="fw-bold text-white mb-1">Drag and drop your image here</h6>
                                <p class="text-secondary small mb-0">or click to browse from device (JPG, PNG)</p>
                                <input type="file" id="photoInput" accept="image/*" class="d-none" onchange="handlePhotoUpload(this)">
                            </div>
                            <div class="form-text text-secondary mt-1 small">
                                <i class="fa-solid fa-lock text-success pe-1"></i> Your photo is rendered locally inside your browser and is never saved or uploaded to our database.
                            </div>
                        </div>

                        <!-- Card Action Hub -->
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <button type="button" class="btn btn-wc-primary flex-grow-1" id="downloadBtn" onclick="generateAndDownload()">
                                <i class="fa-solid fa-download me-2"></i> Download Card Image
                            </button>
                            <button type="button" class="btn btn-wc-facebook flex-grow-1" id="shareBtn" onclick="shareToFacebook()">
                                <i class="fa-brands fa-facebook me-2"></i> Copy & Share
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Panel: Card Preview -->
            <div class="col-12 col-xl-6 text-center">
                <h4 class="fw-semibold text-secondary mb-3 text-uppercase tracking-wider fs-7">
                    <i class="fa-solid fa-circle-check text-success me-1"></i> Live Card Preview
                </h4>

                <div class="wc-card-wrapper mb-4">
                    <!-- The Canvas Card Container -->
                    <div class="wc-canvas-card" id="premiumCard">
                        <!-- Supporter Photo Background layer -->
                        <div class="wc-card-bg-image" id="cardBgPhoto"></div>
                        <div class="wc-card-bg-gradient"></div>
                        <div class="wc-card-accent-glow" id="cardGlow"></div>

                        <!-- Card Contents -->
                        <div class="wc-card-content">
                            <!-- Card Header Info -->
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="wc-card-badge">
                                    <div class="wc-badge-dot"></div>
                                    <span id="cardBadgeTeam">World Cup Fan</span>
                                </div>
                                <span class="wc-brand-logo font-bolder">SIGMATIC<span>SOFT</span></span>
                            </div>

                            <!-- Supporter Info Profile -->
                            <div class="wc-card-supporter">
                                <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236366f1'><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>" class="wc-supporter-avatar" id="cardAvatar" alt="supporter">
                                <div class="wc-supporter-info text-start">
                                    <h4 id="cardName">Fan Supporter</h4>
                                    <p id="cardSubText">Championship Predictor</p>
                                </div>
                            </div>

                            <!-- Single Match VS Box (Real-Time Render) -->
                            <div class="wc-card-vs-container" id="matchCardBox">
                                <div class="wc-card-vs-header" id="cardMatchStage">Fixture Details</div>
                                
                                <div class="wc-card-vs-teams-grid">
                                    <!-- Home Team -->
                                    <div class="wc-card-vs-team-block">
                                        <img src="https://flagcdn.com/w80/un.png" class="wc-card-vs-flag" id="cardHomeFlag" alt="Home">
                                        <span class="wc-card-vs-team-name" id="cardHomeName">Select Team</span>
                                    </div>
                                    
                                    <!-- Predicted Score -->
                                    <div class="wc-card-score-mid">
                                        <div class="wc-card-score-digit" id="cardHomeScore">0</div>
                                        <div class="wc-card-score-colon">:</div>
                                        <div class="wc-card-score-digit" id="cardAwayScore">0</div>
                                    </div>

                                    <!-- Away Team -->
                                    <div class="wc-card-vs-team-block">
                                        <img src="https://flagcdn.com/w80/un.png" class="wc-card-vs-flag" id="cardAwayFlag" alt="Away">
                                        <span class="wc-card-vs-team-name" id="cardAwayName">Opponent</span>
                                    </div>
                                </div>

                                <div class="wc-card-vs-footer" id="cardMatchVenue">Pick your team and match to predict scoreline!</div>
                            </div>

                            <!-- Prediction Bubble -->
                            <div class="wc-card-prediction">
                                <div class="wc-predict-title">Predictor Comments</div>
                                <p class="wc-predict-text" id="cardPrediction">Enter your supporter prediction comments on the left to see live rendering!</p>
                            </div>

                            <!-- Card Footer -->
                            <div class="wc-card-footer">
                                <div class="wc-copyright">Generated via sigmaticsoft.com</div>
                                <div class="fw-bold text-white-50 small"><i class="fa-solid fa-trophy text-warning me-1"></i>2026 World Cup</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-secondary small">
                    <i class="fa-solid fa-arrows-left-right text-indigo"></i> Drag files or type on the left to see instant, responsive rendering.
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Toast -->
    <div class="wc-toast" id="shareToast">
        <i class="fa-solid fa-circle-check"></i>
        <div>
            <strong class="d-block">Prediction Copied!</strong>
            <span class="small text-secondary">Pasted to clipboard. Open Facebook to share your card!</span>
        </div>
    </div>
</div>

<!-- Load html2canvas securely from public CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" referrerpolicy="no-referrer"></script>

<script>
    // Cached matches dataset passed from Laravel backend controller
    const allMatches = @json($matches);

    // Flags mapping database
    const countryFlags = {
        "QAT": "qa", "NED": "nl", "SEN": "sn", "ECU": "ec",
        "ENG": "gb-eng", "WAL": "gb-wls", "IRN": "ir", "USA": "us",
        "MEX": "mx", "POL": "pl", "ARG": "ar", "KSA": "sa",
        "TUN": "tn", "AUS": "au", "DEN": "dk", "FRA": "fr",
        "ESP": "es", "JPN": "jp", "CRC": "cr", "GER": "de",
        "BEL": "be", "CRO": "hr", "CAN": "ca", "MAR": "ma",
        "BRA": "br", "SRB": "rs", "CMR": "cm", "SUI": "ch",
        "GHA": "gh", "URU": "uy", "POR": "pt", "KOR": "kr"
    };

    // Color theme mappings
    const teamColors = {
        "ARG": "rgba(116, 172, 223, 0.4)", // Light Blue
        "BRA": "rgba(255, 223, 0, 0.4)",   // Canary Yellow
        "FRA": "rgba(0, 85, 164, 0.4)",    // Royal Blue
        "POR": "rgba(218, 41, 28, 0.4)",   // Portuguese Red
        "GER": "rgba(255, 255, 255, 0.4)", // White/Silver
        "ESP": "rgba(241, 191, 0, 0.4)",   // Spanish Gold
        "ENG": "rgba(207, 8, 15, 0.4)",    // St George Red
        "NED": "rgba(243, 98, 0, 0.4)",    // Dutch Orange
        "BEL": "rgba(224, 0, 37, 0.4)",    // Belgian Red
        "CRO": "rgba(255, 0, 0, 0.4)",      // Checkered Red
        "URU": "rgba(85, 182, 226, 0.4)",  // Sky Blue
        "USA": "rgba(0, 40, 104, 0.4)",    // Navy
        "CAN": "rgba(255, 0, 0, 0.35)",     // Canada Red
        "MEX": "rgba(0, 104, 71, 0.4)",    // Mexico Green
        "JPN": "rgba(188, 0, 45, 0.4)",    // Blue/Red
        "MAR": "rgba(0, 98, 51, 0.4)"      // Green
    };

    // Initialize elements
    const teamSelect = document.getElementById('teamSelect');
    const opponentSelectGroup = document.getElementById('opponentSelectGroup');
    const opponentSelect = document.getElementById('opponentSelect');
    const customMatchFields = document.getElementById('customMatchFields');
    const customStadium = document.getElementById('customStadium');
    const customStage = document.getElementById('customStage');
    const matchModeContainer = document.getElementById('matchModeContainer');
    const customMatchToggle = document.getElementById('customMatchToggle');
    const matchModeInfo = document.getElementById('matchModeInfo');

    // Cache list of all teams for easy lookup
    const allTeams = Array.from(teamSelect.options)
        .filter(opt => opt.value)
        .map(opt => ({
            code: opt.value,
            text: opt.text
        }));

    const scoreInputsGroup = document.getElementById('scoreInputsGroup');
    const homeScoreLabel = document.getElementById('homeScoreLabel');
    const awayScoreLabel = document.getElementById('awayScoreLabel');
    const homeScoreInput = document.getElementById('homeScoreInput');
    const awayScoreInput = document.getElementById('awayScoreInput');
    
    const supporterNameInput = document.getElementById('supporterName');
    const predictionTextInput = document.getElementById('predictionText');
    const photoInput = document.getElementById('photoInput');

    const cardBgPhoto = document.getElementById('cardBgPhoto');
    const cardGlow = document.getElementById('cardGlow');
    const cardAvatar = document.getElementById('cardAvatar');
    const cardName = document.getElementById('cardName');
    const cardSubText = document.getElementById('cardSubText');
    const cardBadgeTeam = document.getElementById('cardBadgeTeam');
    const cardPrediction = document.getElementById('cardPrediction');
    
    // Card VS Elements
    const cardMatchStage = document.getElementById('cardMatchStage');
    const cardHomeFlag = document.getElementById('cardHomeFlag');
    const cardHomeName = document.getElementById('cardHomeName');
    const cardAwayFlag = document.getElementById('cardAwayFlag');
    const cardAwayName = document.getElementById('cardAwayName');
    const cardHomeScore = document.getElementById('cardHomeScore');
    const cardAwayScore = document.getElementById('cardAwayScore');
    const cardMatchVenue = document.getElementById('cardMatchVenue');

    // Real-time Text synchronization
    supporterNameInput.addEventListener('input', (e) => {
        const val = e.target.value.trim();
        cardName.innerText = val ? val : "Fan Supporter";
    });

    predictionTextInput.addEventListener('input', (e) => {
        const val = e.target.value.trim();
        cardPrediction.innerText = val ? val : "Enter your supporter prediction comments on the left to see live rendering!";
    });

    // Score Inputs synchronization
    homeScoreInput.addEventListener('input', (e) => {
        let val = parseInt(e.target.value);
        if (isNaN(val) || val < 0) val = 0;
        cardHomeScore.innerText = val;
    });

    awayScoreInput.addEventListener('input', (e) => {
        let val = parseInt(e.target.value);
        if (isNaN(val) || val < 0) val = 0;
        cardAwayScore.innerText = val;
    });

    // Handle Team Selection
    teamSelect.addEventListener('change', (e) => {
        const selectedCode = e.target.value;
        const selectedText = e.target.options[e.target.selectedIndex].text;
        
        // 1. Update card badge and subtext
        cardBadgeTeam.innerText = `${selectedText.split(' ')[0]} Supporter`;
        cardSubText.innerText = `${selectedText.split(' ')[0]} Official Predictor`;

        // 2. Set card accent color
        const glowColor = teamColors[selectedCode] || "rgba(99, 102, 241, 0.25)";
        cardGlow.style.setProperty('--team-glow', glowColor);

        // 3. Show and configure match mode toggle
        matchModeContainer.classList.remove('d-none');
        const teamMatches = allMatches.filter(match => {
            return (match.home_team_country === selectedCode || match.away_team_country === selectedCode);
        });

        if (teamMatches.length === 0) {
            customMatchToggle.checked = true;
            customMatchToggle.disabled = true;
            matchModeInfo.innerText = "No official fixtures found. Dream Matchup active!";
        } else {
            customMatchToggle.checked = false;
            customMatchToggle.disabled = false;
            matchModeInfo.innerText = "Show custom matches against any of the 32 teams.";
        }

        // 4. Filter matches for selected country and populate Opponents Selector
        populateOpponentsForTeam(selectedCode);
    });

    // Custom match toggle listener
    customMatchToggle.addEventListener('change', () => {
        if (teamSelect.value) {
            populateOpponentsForTeam(teamSelect.value);
        }
    });

    // Populate opponents dropdown based on team
    function populateOpponentsForTeam(teamCode) {
        if (!allMatches || allMatches.length === 0) return;

        // Find official matches where this team is playing
        const teamMatches = allMatches.filter(match => {
            return (match.home_team_country === teamCode || match.away_team_country === teamCode);
        });

        const isCustomMode = customMatchToggle.checked;

        let optionsHtml = '<option value="" disabled selected>-- Select Opponent / Matchup --</option>';
        
        // 1. Add official opponents if there are official matches AND custom mode is not enabled
        if (teamMatches.length > 0 && !isCustomMode) {
            optionsHtml += `<optgroup label="Official World Cup Fixtures">`;
            teamMatches.forEach(match => {
                const date = new Date(match.datetime);
                const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                
                // Determine opponent team name
                const isHome = match.home_team_country === teamCode;
                const opponentName = isHome ? match.away_team.name : match.home_team.name;
                const stage = match.stage_name || 'Group Stage';
                
                optionsHtml += `
                    <option value="official_${match.id}">${opponentName} (${stage} • ${dateStr})</option>
                `;
            });
            optionsHtml += `</optgroup>`;
        }

        // 2. Add all other teams as custom matchups if custom mode is enabled or if there are no official matches
        if (isCustomMode || teamMatches.length === 0) {
            optionsHtml += `<optgroup label="✨ Create Custom Dream Matchup...">`;
            allTeams.forEach(team => {
                // Exclude the selected team itself
                if (team.code === teamCode) return;
                
                optionsHtml += `
                    <option value="custom_${team.code}">${team.text} (Dream Match)</option>
                `;
            });
            optionsHtml += `</optgroup>`;
        }

        opponentSelect.innerHTML = optionsHtml;
        opponentSelectGroup.classList.remove('d-none');
        
        // Hide score inputs and custom fields until choice is made
        scoreInputsGroup.classList.add('d-none');
        customMatchFields.classList.add('d-none');
    }

    // Handle Opponent Selector Change
    opponentSelect.addEventListener('change', (e) => {
        const val = e.target.value;

        if (val.startsWith('custom_')) {
            // Reveal Custom Fields
            customMatchFields.classList.remove('d-none');
            scoreInputsGroup.classList.remove('d-none');
            
            // Reset scores
            homeScoreInput.value = 0;
            awayScoreInput.value = 0;
            cardHomeScore.innerText = 0;
            cardAwayScore.innerText = 0;

            updateCustomMatchCard();
        } else if (val.startsWith('official_')) {
            // Hide Custom Fields
            customMatchFields.classList.add('d-none');
            scoreInputsGroup.classList.remove('d-none');
            
            const matchId = parseInt(val.replace('official_', ''));
            const match = allMatches.find(m => m.id === matchId);
            if (!match) return;

            // Load official match preview details
            updateOfficialMatchCard(match);
        }
    });

    // Update Card details with Official pre-populated slot
    function updateOfficialMatchCard(match) {
        homeScoreLabel.innerText = match.home_team.name;
        awayScoreLabel.innerText = match.away_team.name;

        // Reset scoreboards
        homeScoreInput.value = 0;
        awayScoreInput.value = 0;
        cardHomeScore.innerText = 0;
        cardAwayScore.innerText = 0;

        let stage = match.stage_name || 'Group Stage Match';
        cardMatchStage.innerText = stage;

        const homeFlag = countryFlags[match.home_team_country] || 'un';
        const awayFlag = countryFlags[match.away_team_country] || 'un';

        cardHomeFlag.src = `https://flagcdn.com/w80/${homeFlag}.png`;
        cardHomeFlag.alt = match.home_team.name;
        cardHomeName.innerText = match.home_team.name;

        cardAwayFlag.src = `https://flagcdn.com/w80/${awayFlag}.png`;
        cardAwayFlag.alt = match.away_team.name;
        cardAwayName.innerText = match.away_team.name;

        const date = new Date(match.datetime);
        const dateStr = date.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
        const timeStr = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        
        cardMatchVenue.innerText = `${dateStr} @ ${timeStr} • ${match.venue}, ${match.location}`;
    }

    // Update Card details with Custom user-defined dream matchup parameters
    function updateCustomMatchCard() {
        if (!teamSelect.value || !opponentSelect.value) return;

        const selectedTeamCode = teamSelect.value;
        const selectedTeamText = teamSelect.options[teamSelect.selectedIndex].text.split(' ')[0];
        
        const opponentVal = opponentSelect.value;
        if (!opponentVal || !opponentVal.startsWith('custom_')) return;
        
        const opponentCode = opponentVal.replace('custom_', '');
        const teamObj = allTeams.find(t => t.code === opponentCode);
        const opponentText = teamObj ? teamObj.text.split(' ')[0] : "Opponent";

        const stadiumFullText = customStadium.options[customStadium.selectedIndex].text;
        const stageName = customStage.value;

        // Sync Form Labels
        homeScoreLabel.innerText = selectedTeamText;
        awayScoreLabel.innerText = opponentText;

        // Sync Card Layout
        cardMatchStage.innerText = stageName;

        const homeFlag = countryFlags[selectedTeamCode] || 'un';
        const awayFlag = countryFlags[opponentCode] || 'un';

        cardHomeFlag.src = `https://flagcdn.com/w80/${homeFlag}.png`;
        cardHomeFlag.alt = selectedTeamText;
        cardHomeName.innerText = selectedTeamText;

        cardAwayFlag.src = `https://flagcdn.com/w80/${awayFlag}.png`;
        cardAwayFlag.alt = opponentText;
        cardAwayName.innerText = opponentText;

        cardHomeScore.innerText = homeScoreInput.value;
        cardAwayScore.innerText = awayScoreInput.value;

        cardMatchVenue.innerText = `June/July 2026 • ${stadiumFullText}`;
    }

    // Attach custom field listeners to refresh layout instantly
    [customStadium, customStage].forEach(elem => {
        elem.addEventListener('change', updateCustomMatchCard);
    });

    // Client-Side Image Upload & Local Preview Processing
    function handlePhotoUpload(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                cardAvatar.src = e.target.result;
                cardBgPhoto.style.backgroundImage = `url('${e.target.result}')`;
                cardBgPhoto.style.opacity = '0.30';

                const dropZone = document.getElementById('dropZone');
                dropZone.style.borderColor = '#10b981';
                dropZone.style.backgroundColor = 'rgba(16, 185, 129, 0.05)';
                dropZone.innerHTML = `
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <h6 class="fw-bold text-success mb-1">Image Loaded Successfully!</h6>
                    <p class="text-secondary small mb-0">${input.files[0].name}</p>
                `;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Drag and drop mechanics
    const dropZone = document.getElementById('dropZone');
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#6366f1';
            dropZone.style.backgroundColor = 'rgba(99, 102, 241, 0.08)';
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            if (eventName === 'drop') {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length) {
                    photoInput.files = files;
                    handlePhotoUpload(photoInput);
                }
            } else {
                dropZone.style.borderColor = 'rgba(99, 102, 241, 0.4)';
                dropZone.style.backgroundColor = 'rgba(99, 102, 241, 0.02)';
            }
        }, false);
    });

    // High-Resolution Image download mechanics using html2canvas
    function generateAndDownload() {
        if (!teamSelect.value) {
            alert('Please select a team before downloading your card!');
            return;
        }
        if (!opponentSelect.value) {
            alert('Please select an opponent or create a custom matchup!');
            return;
        }

        const downloadBtn = document.getElementById('downloadBtn');
        const originalText = downloadBtn.innerHTML;
        
        downloadBtn.disabled = true;
        downloadBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-2"></i> Generating Card...`;

        const targetCard = document.getElementById('premiumCard');

        html2canvas(targetCard, {
            scale: 1.5,
            useCORS: true,
            allowTaint: false,
            backgroundColor: '#0f111a',
            logging: false
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const downloadLink = document.createElement('a');
            
            const teamName = teamSelect.options[teamSelect.selectedIndex].text.split(' ')[0].toLowerCase();
            const supporterName = supporterNameInput.value.trim().toLowerCase().replace(/[^a-z0-9]/g, '_') || 'predictor';
            
            downloadLink.href = imgData;
            downloadLink.download = `worldcup2026_prediction_${teamName}_${supporterName}.png`;
            
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);

            downloadBtn.disabled = false;
            downloadBtn.innerHTML = originalText;
        }).catch(err => {
            console.error('Image capture failed:', err);
            alert('Could not render the card. Please try uploading a different photo size or check your internet connection.');
            downloadBtn.disabled = false;
            downloadBtn.innerHTML = originalText;
        });
    }

    // Social share to Facebook workflows
    function shareToFacebook() {
        if (!teamSelect.value || !opponentSelect.value) {
            alert('Please select a team and predict a match score before sharing!');
            return;
        }

        const homeName = cardHomeName.innerText;
        const awayName = cardAwayName.innerText;
        const homeScore = cardHomeScore.innerText;
        const awayScore = cardAwayScore.innerText;
        
        const name = supporterNameInput.value.trim() || 'A supporter';
        const comments = predictionTextInput.value.trim() || 'Predicting matchday victory!';
        
        const shareText = `🏆 2026 World Cup Prediction Card! 🏆\n⚽ Predictor: ${name}\n🔥 Match: ${homeName} [ ${homeScore} ] - [ ${awayScore} ] ${awayName}\n✨ Verdict: "${comments}"\n\nGenerated via Sigmaticsoft 2026 Match Predictor!`;

        // 1. Copy prediction details to clipboard automatically
        navigator.clipboard.writeText(shareText).then(() => {
            const toast = document.getElementById('shareToast');
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }).catch(err => {
            console.error('Clipboard copy failed:', err);
        });

        // 2. Mobile Native Web Share API integration
        const targetCard = document.getElementById('premiumCard');
        
        if (navigator.share && navigator.canShare && window.File) {
            html2canvas(targetCard, { scale: 1.5, useCORS: true }).then(canvas => {
                canvas.toBlob(blob => {
                    const file = new File([blob], "match_prediction_card.png", { type: "image/png" });
                    
                    if (navigator.canShare({ files: [file] })) {
                        navigator.share({
                            title: 'My Match Prediction Card',
                            text: shareText,
                            files: [file]
                        }).catch(e => {
                            openFacebookShare();
                        });
                    } else {
                        openFacebookShare();
                    }
                }, 'image/png');
            });
        } else {
            // 3. Fallback to Facebook Sharer Link
            openFacebookShare();
        }
    }

    function openFacebookShare() {
        const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent('https://sigmaticsoft.com/worldcup')}`;
        window.open(url, '_blank', 'width=600,height=450,location=no,toolbar=no,menubar=no,status=no,resizable=yes');
    }
</script>
@endsection

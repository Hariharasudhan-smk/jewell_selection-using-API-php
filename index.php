<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanishq Jewelry Price Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: cyan;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #8492e3;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #8492e3;
        }

        .header {
            background: linear-gradient(135deg, #8492e3, #ff179e);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 3em;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.3em;
            opacity: 0.95;
        }

        .form-container {
            padding: 50px;
            background: #acf29b;
        }

        .gold-rate-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            border: 2px solid #e9ecef;
        }

        .gold-rate-display h3 {
            color: #FF00FF;
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .gold-rate-value {
            font-size: 2em;
            color: #667eea;
            font-weight: bold;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .form-group:hover {
            transform: translateY(-3px);
        }

        label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1em;
        }

        select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            background: white;
            transition: all 0.3s ease;
        }

        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.2);
        }

        .btn-container {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .loading {
            display: none;
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 15px;
            margin: 20px 0;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .result {
            display: none;
            background: white;
            padding: 30px;
            margin-top: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .price-breakdown {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            border-left: 5px solid #667eea;
        }

        .price-breakdown h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.5em;
            text-align: center;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
            font-size: 1.1em;
        }

        .breakdown-item:last-child {
            border-bottom: none;
        }

        .breakdown-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .breakdown-value {
            font-weight: bold;
            color: #667eea;
        }

        .final-price {
            font-size: 2.5em;
            color: #2c3e50;
            font-weight: bold;
            padding: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .jewelry-info {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            border: 2px solid #e9ecef;
            margin-bottom: 20px;
            text-align: center;
        }

        .jewelry-name {
            font-size: 1.3em;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .error {
            background: #fff5f5;
            color: #e53e3e;
            padding: 20px;
            border-radius: 15px;
            border-left: 5px solid #e53e3e;
            margin-top: 20px;
            display: none;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .form-container {
                padding: 30px 20px;
            }

            .breakdown-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .final-price {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💎 Tanishq Jewelry Calculator</h1>
            <p>Calculate the exact price of your dream jewelry</p>
        </div>

        <div class="form-container">
            <div class="gold-rate-display">
                <h3>📈 Current Gold Rate</h3>
                <div class="gold-rate-value">₹9,534 per gram</div>
            </div>

            <form id="calculatorForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="jewelryType">🏆 Select Jewelry Type:</label>
                        <select id="jewelryType" name="jewelry_type" required>
                            <option value="">Choose jewelry type...</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="designSelect">✨ Select Design:</label>
                        <select id="designSelect" name="design_id" required disabled>
                            <option value="">First select jewelry type...</option>
                        </select>
                    </div>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn">💰 Calculate Price</button>
                </div>
            </form>

            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p>Calculating your jewelry price...</p>
            </div>

            <div class="error" id="error"></div>

            <div class="result" id="result">
                <div class="jewelry-info" id="jewelryInfo"></div>
                
                <div class="price-breakdown">
                    <h3>💎 Price Breakdown</h3>
                    <div id="breakdownDetails"></div>
                </div>

                <div class="final-price" id="finalPrice"></div>
            </div>
        </div>
    </div>

    <script>
        // Sample data for demonstration
        const jewelryTypes = [
            {id: 1, type_name: 'Rings'},
            {id: 2, type_name: 'Necklaces'},
            {id: 3, type_name: 'Bracelets'}
        ];

        const jewelryDesigns = {
            1: [ // Rings
                {id: 1, design_name: 'The Tanishq Classic Oval Gold Ring', weight: 3.25, making_charges: 3500, wastage_percentage: 18, tax_percentage: 3, gemstone_count: 1},
                {id: 2, design_name: 'The Tanishq Rose Gold Diamond Ring', weight: 2.8, making_charges: 5200, wastage_percentage: 20, tax_percentage: 3, gemstone_count: 5},
                {id: 3, design_name: 'The Mia Heart Design Gold Ring', weight: 1.9, making_charges: 2000, wastage_percentage: 15, tax_percentage: 3, gemstone_count: 2}
            ],
            2: [ // Necklaces
                {id: 4, design_name: 'The Tanishq Traditional Gold Necklace', weight: 68.3, making_charges: 15000, wastage_percentage: 22, tax_percentage: 3, gemstone_count: 10},
                {id: 5, design_name: 'The Tanishq Diamond Floral Necklace', weight: 35.6, making_charges: 18500, wastage_percentage: 20, tax_percentage: 3, gemstone_count: 12},
                {id: 6, design_name: 'The Mia Lightweight Pendant Necklace', weight: 12.4, making_charges: 4500, wastage_percentage: 16, tax_percentage: 3, gemstone_count: 3}
            ],
            3: [ // Bracelets
                {id: 7, design_name: 'The Titan Link Bracelet for Men', weight: 18.2, making_charges: 2800, wastage_percentage: 12, tax_percentage: 18, gemstone_count: 0},
                {id: 8, design_name: 'The Tanishq Gold Kada Bracelet', weight: 25.0, making_charges: 6200, wastage_percentage: 19, tax_percentage: 3, gemstone_count: 1},
                {id: 9, design_name: 'The Mia Charm Bracelet', weight: 10.5, making_charges: 3100, wastage_percentage: 14, tax_percentage: 3, gemstone_count: 4}
            ]
        };

        // Load jewelry types on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadJewelryTypes();
        });

        // Load jewelry types
        function loadJewelryTypes() {
            const select = document.getElementById('jewelryType');
            select.innerHTML = '<option value="">Choose jewelry type...</option>';
            
            jewelryTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = type.type_name;
                select.appendChild(option);
            });
        }

        // Load designs based on jewelry type
        document.getElementById('jewelryType').addEventListener('change', function() {
            const typeId = parseInt(this.value);
            const designSelect = document.getElementById('designSelect');
            
            if (typeId && jewelryDesigns[typeId]) {
                designSelect.innerHTML = '<option value="">Choose design...</option>';
                
                jewelryDesigns[typeId].forEach(design => {
                    const option = document.createElement('option');
                    option.value = design.id;
                    option.textContent = design.design_name;
                    designSelect.appendChild(option);
                });
                
                designSelect.disabled = false;
            } else {
                designSelect.innerHTML = '<option value="">First select jewelry type...</option>';
                designSelect.disabled = true;
            }
        });

        // Handle form submission
        document.getElementById('calculatorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const designId = parseInt(document.getElementById('designSelect').value);
            if (!designId) {
                showError('Please select a design');
                return;
            }

            const loading = document.getElementById('loading');
            const result = document.getElementById('result');
            const error = document.getElementById('error');
            
            // Show loading
            loading.style.display = 'block';
            result.style.display = 'none';
            error.style.display = 'none';
            
            // Find the selected design
            let selectedDesign = null;
            for (let typeId in jewelryDesigns) {
                const design = jewelryDesigns[typeId].find(d => d.id === designId);
                if (design) {
                    selectedDesign = design;
                    break;
                }
            }
            
            if (!selectedDesign) {
                loading.style.display = 'none';
                showError('Design not found');
                return;
            }
            
            // Calculate price with fixed gold rate of 9534
            setTimeout(() => {
                const goldRate = 9534;
                const weight = selectedDesign.weight;
                const makingCharges = selectedDesign.making_charges;
                const wastagePercentage = selectedDesign.wastage_percentage;
                const taxPercentage = selectedDesign.tax_percentage;
                const gemstoneCount = selectedDesign.gemstone_count;
                const gemstonePrice = 0; // Default
                
                // Calculate prices
                const goldCost = weight * goldRate;
                const wastageCost = goldCost * (wastagePercentage / 100);
                const totalGemstoneCost = gemstoneCount * gemstonePrice;
                const subtotal = goldCost + makingCharges + wastageCost + totalGemstoneCost;
                const taxAmount = subtotal * (taxPercentage / 100);
                const totalPrice = subtotal + taxAmount;
                
                loading.style.display = 'none';
                
                const data = {
                    success: true,
                    jewelry_name: selectedDesign.design_name,
                    weight: weight,
                    gold_cost: goldCost,
                    making_charges: makingCharges,
                    wastage_percentage: wastagePercentage,
                    wastage_cost: wastageCost,
                    tax_percentage: taxPercentage,
                    tax_amount: taxAmount,
                    gemstone_count: gemstoneCount,
                    total_price: totalPrice
                };
                
                displayResult(data);
            }, 1000);
        });

        // Display calculation result with detailed breakdown
        function displayResult(data) {
            const result = document.getElementById('result');
            const jewelryInfo = document.getElementById('jewelryInfo');
            const breakdownDetails = document.getElementById('breakdownDetails');
            const finalPrice = document.getElementById('finalPrice');
            
            // Show jewelry info
            jewelryInfo.innerHTML = `
                <div class="jewelry-name">${data.jewelry_name}</div>
            `;
            
            // Show detailed breakdown
            breakdownDetails.innerHTML = `
                <div class="breakdown-item">
                    <span class="breakdown-label">Gold Weight:</span>
                    <span class="breakdown-value">${data.weight} grams</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Gold Cost (₹9,534/gram):</span>
                    <span class="breakdown-value">₹${data.gold_cost.toLocaleString('en-IN', {maximumFractionDigits: 0})}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Making Charges:</span>
                    <span class="breakdown-value">₹${data.making_charges.toLocaleString('en-IN', {maximumFractionDigits: 0})}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Wastage (${data.wastage_percentage}%):</span>
                    <span class="breakdown-value">₹${data.wastage_cost.toLocaleString('en-IN', {maximumFractionDigits: 0})}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Tax (${data.tax_percentage}%):</span>
                    <span class="breakdown-value">₹${data.tax_amount.toLocaleString('en-IN', {maximumFractionDigits: 0})}</span>
                </div>
                ${data.gemstone_count > 0 ? `
                <div class="breakdown-item">
                    <span class="breakdown-label">Gemstones (${data.gemstone_count} pieces):</span>
                    <span class="breakdown-value">₹0</span>
                </div>
                ` : ''}
            `;
            
            // Show final price
            finalPrice.innerHTML = `Total Price: ₹${data.total_price.toLocaleString('en-IN', {maximumFractionDigits: 0})}`;
            
            result.style.display = 'block';
        }

        // Show error message
        function showError(message) {
            const error = document.getElementById('error');
            error.textContent = message;
            error.style.display = 'block';
        }
    </script>
</body>
</html>

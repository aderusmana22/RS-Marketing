<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisition Slip - Comment Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            border: 1px solid #e8ecef;
        }

        .header {
            background: linear-gradient(135deg, #deca1b 0%, #817c2c 100%);
            color: rgb(255, 255, 255);
            padding: 25px 30px;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .title-icon {
            background: rgba(255, 255, 255, 0.2);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .form-container {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }


        .form-textarea {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
            line-height: 1.6;
        }

        .input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .priority-selector {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

       
        .action-section {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 2px solid #f1f5f9;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

      
        .btn-approved {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(63, 210, 9, 0.3);
            position: relative;
            z-index: 1;
        }

        .btn-approved:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(55, 203, 29, 0.4);
        }

        .btn-approved:active {
            transform: translateY(-1px);
        }

       
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                max-width: none;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .input-group {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .action-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .status-indicator {
                margin: 0 0 15px 0;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">
                <span class="title-icon">📋</span>
                Requisition Slip
            </h1>
        </div>
        
        <div class="form-container">
            <form id="requisitionForm">
                <div class="form-group">
                    <label class="form-label" for="itemDescription">Comment</label>
                    <textarea id="itemDescription" class="form-input form-textarea" placeholder="Describe the items or services requested..." required></textarea>
                </div>

                <div class="action-section">
                    
                    <button type="submit" class="btn btn-approved">Approved</button>
                </div>
            </form>
        </div>
    </div>

    

</body>
</html>
<template>
    <div id="app">
        <div class="container">
            <header>
                <h1>EduRate</h1>
                <p class="subtitle">Upload your documents here</p>
            </header>

            <main class="upload-container">
                <div class="upload-area" 
                     @click="triggerFileInput"
                     @drop="handleDrop"
                     @dragover="handleDragOver"
                     @dragleave="handleDragLeave"
                     :class="{ 'dragover': isDragging }">
                    <div class="upload-icon">
                        <i>📁</i>
                    </div>
                    <div class="upload-text">
                        <h3>Drag & Drop Files Here</h3>
                        <p>Supported formats: PDF, DOC, DOCX, JPG, PNG (Max 10MB)</p>
                    </div>
                    <button class="browse-btn">Browse Files</button>
                    <input type="file" 
                           ref="fileInput" 
                           class="file-input" 
                           multiple 
                           @change="handleFileSelect">
                </div>

                <div class="file-list">
                    <h3>Selected Files</h3>
                    <div v-if="files.length === 0" class="empty-state">
                        No files selected
                    </div>
                    <div v-else>
                        <div v-for="(file, index) in files" :key="index" class="file-item">
                            <div class="file-info">
                                <div class="file-icon">
                                    <i>📄</i>
                                </div>
                                <div class="file-details">
                                    <h4>{{ file.name }}</h4>
                                    <p>{{ formatFileSize(file.size) }}</p>
                                </div>
                            </div>
                            <div class="file-actions">
                                <button class="file-action-btn" @click="removeFile(index)" title="Remove file">
                                    🗑️
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="upload-progress" v-if="uploading">
                    <div class="upload-status">
                        <span>Uploading...</span>
                        <span>{{ progress }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress" :style="{ width: progress + '%' }"></div>
                    </div>
                </div>

                <div class="upload-actions" v-if="files.length > 0 && !uploading">
                    <button class="action-btn cancel-btn" @click="clearFiles">Cancel</button>
                    <button class="action-btn submit-btn" @click="uploadFiles">Upload Files</button>
                </div>

                <div class="success-message" :class="{ 'show': uploadComplete }">
                    <h3>✅ Upload Successful!</h3>
                    <p>Your files have been uploaded successfully.</p>
                </div>
            </main>

        </div>
    </div> 
</template>

<style scoped>
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, #ffa726, #ff9800);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .subtitle {
            font-size: 1.1rem;
            color: #aaa;
        }

        .upload-container {
            background: rgba(40, 40, 40, 0.8);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 167, 38, 0.2);
        }

        .upload-area {
            border: 2px dashed rgba(255, 167, 38, 0.5);
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(30, 30, 30, 0.5);
            margin-bottom: 25px;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: #ffa726;
            background: rgba(40, 40, 40, 0.8);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(255, 167, 38, 0.2);
        }

        .upload-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: #ffa726;
        }

        .upload-text {
            margin-bottom: 20px;
        }

        .upload-text h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #ffa726;
        }

        .upload-text p {
            color: #aaa;
            font-size: 0.95rem;
        }

        .browse-btn {
            background: linear-gradient(to right, #ffa726, #ff9800);
            color: #1a1a1a;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            margin-top: 10px;
        }

        .browse-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 167, 38, 0.4);
        }

        .file-input {
            display: none;
        }

        .file-list {
            margin-top: 25px;
        }

        .file-list h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #ffa726;
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: rgba(50, 50, 50, 0.6);
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #ffa726;
            transition: all 0.3s ease;
        }

        .file-item:hover {
            background: rgba(60, 60, 60, 0.8);
            transform: translateX(5px);
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-icon {
            color: #ffa726;
            font-size: 24px;
        }

        .file-details h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .file-details p {
            font-size: 0.8rem;
            color: #aaa;
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        .file-action-btn {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.2s ease;
        }

        .file-action-btn:hover {
            color: #ffa726;
        }

        .upload-progress {
            margin-top: 20px;
        }

        .progress-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress {
            height: 100%;
            background: linear-gradient(to right, #ffa726, #ff9800);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .upload-status {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.85rem;
            color: #aaa;
        }

        .empty-state {
            text-align: center;
            padding: 20px;
            color: #777;
            font-style: italic;
        }

        .upload-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
        }

        .action-btn {
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
        }

        .cancel-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #f5f5f5;
        }

        .submit-btn {
            background: linear-gradient(to right, #ffa726, #ff9800);
            color: #1a1a1a;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 167, 38, 0.3);
        }

        .success-message {
            text-align: center;
            padding: 20px;
            background: rgba(76, 175, 80, 0.2);
            border-radius: 10px;
            margin-top: 20px;
            color: #4caf50;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 600px) {
            .upload-container {
                padding: 20px;
            }
            
            .upload-area {
                padding: 30px 15px;
            }
            
            h1 {
                font-size: 2rem;
            }
        } 
</style>
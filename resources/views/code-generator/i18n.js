// Internationalization Utilities
const I18n = {
    // Current language
    currentLang: 'en',
    
    // Available languages
    languages: {
        en: 'English',
        es: 'Español',
        fr: 'Français',
        de: 'Deutsch',
        zh: '中文',
        ja: '日本語',
        ar: 'العربية',
        ru: 'Русский',
        pt: 'Português',
        hi: 'हिन्दी',
        
        // Indian Languages
        bn: 'বাংলা', // Bengali
        te: 'తెలుగు', // Telugu
        ta: 'தமிழ்', // Tamil
        mr: 'मराठी', // Marathi
        gu: 'ગુજરાતી', // Gujarati
        kn: 'ಕನ್ನಡ', // Kannada
        ml: 'മലയാളം', // Malayalam
        pa: 'ਪੰਜਾਬੀ', // Punjabi
        or: 'ଓଡ଼ିଆ', // Odia
        as: 'অসমীয়া', // Assamese
        sa: 'संस्कृतम्', // Sanskrit
        
        // Additional International Languages
        ko: '한국어', // Korean
        it: 'Italiano', // Italian
        nl: 'Nederlands', // Dutch
        pl: 'Polski', // Polish
        tr: 'Türkçe', // Turkish
        sv: 'Svenska', // Swedish
        da: 'Dansk', // Danish
        fi: 'Suomi', // Finnish
        no: 'Norsk', // Norwegian
        cs: 'Čeština', // Czech
        hu: 'Magyar', // Hungarian
        ro: 'Română', // Romanian
        bg: 'Български', // Bulgarian
        el: 'Ελληνικά', // Greek
        he: 'עברית', // Hebrew
        fa: 'فارسی', // Persian
        th: 'ไทย', // Thai
        vi: 'Tiếng Việt', // Vietnamese
        id: 'Bahasa Indonesia', // Indonesian
        ms: 'Bahasa Melayu', // Malay
        fil: 'Filipino', // Filipino
        uk: 'Українська', // Ukrainian
        hr: 'Hrvatski', // Croatian
        sk: 'Slovenčina', // Slovak
        sl: 'Slovenščina', // Slovenian
        et: 'Eesti', // Estonian
        lv: 'Latviešu', // Latvian
        lt: 'Lietuvių', // Lithuanian
        is: 'Íslenska', // Icelandic
        ga: 'Gaeilge', // Irish
        cy: 'Cymraeg', // Welsh
        eu: 'Euskara', // Basque
        ca: 'Català', // Catalan
        gl: 'Galego', // Galician
        sr: 'Српски', // Serbian
        mk: 'Македонски', // Macedonian
        bs: 'Bosanski', // Bosnian
        sq: 'Shqip', // Albanian
        hy: 'Հայերեն', // Armenian
        ka: 'ქართული', // Georgian
        uz: "O'zbek", // Uzbek
        kk: 'Қазақ', // Kazakh
        ky: 'Кыргызча', // Kyrgyz
        tg: 'Тоҷикӣ', // Tajik
        mn: 'Монгол', // Mongolian
        ne: 'नेपाली', // Nepali
        si: 'සිංහල', // Sinhala
        my: 'မြန်မာ', // Burmese
        km: 'ខ្មែរ', // Khmer
        lo: 'ລາວ', // Lao
        am: 'አማርኛ', // Amharic
        ti: 'ትግርኛ', // Tigrinya
        om: 'Afaan Oromoo', // Oromo
        so: 'Soomaali', // Somali
        sw: 'Kiswahili', // Swahili
        ha: 'Hausa', // Hausa
        yo: 'Yorùbá', // Yoruba
        ig: 'Igbo', // Igbo
        zu: 'isiZulu', // Zulu
        xh: 'isiXhosa', // Xhosa
        st: 'Sesotho', // Sesotho
        tn: 'Setswana', // Tswana
        ss: 'siSwati', // Swati
        ve: 'Tshivenḓa', // Venda
        ts: 'Xitsonga', // Tsonga
        nr: 'isiNdebele', // Ndebele
        sn: 'chiShona', // Shona
        rw: 'Kinyarwanda', // Kinyarwanda
        ny: 'Chichewa', // Chichewa
        mg: 'Malagasy', // Malagasy
        co: 'Corsu', // Corsican
        gd: 'Gàidhlig', // Scottish Gaelic
        gv: 'Gaelg', // Manx
        kw: 'Kernewek', // Cornish
        br: 'Brezhoneg', // Breton
        fy: 'Frysk', // Frisian
        lb: 'Lëtzebuergesch', // Luxembourgish
        mt: 'Malti', // Maltese
        mi: 'Māori', // Maori
        sm: 'Gagana Samoa', // Samoan
        to: 'Lea faka-Tonga', // Tongan
        fj: 'Vosa Vakaviti', // Fijian
        haw: 'ʻŌlelo Hawaiʻi', // Hawaiian
        chr: 'ᏣᎳᎩ', // Cherokee
        iu: 'ᐃᓄᒃᑎᑐᑦ', // Inuktitut
        oj: 'ᐊᓂᔑᓇᐯᒧᐎᓐ', // Ojibwe
        cr: 'ᓀᐦᐃᔭᐍᐏᐣ', // Cree
        hmn: 'Hmong', // Hmong
        bo: 'བོད་ཡིག', // Tibetan
        dz: 'རྫོང་ཁ', // Dzongkha
        sd: 'سنڌي', // Sindhi
        ps: 'پښتو', // Pashto
        ur: 'اردو', // Urdu
        ku: 'Kurdî', // Kurdish
        ckb: 'کوردی', // Central Kurdish
        ug: 'ئۇيغۇرچە', // Uyghur
        tt: 'Татар', // Tatar
        ba: 'Башҡорт', // Bashkir
        cv: 'Чӑваш', // Chuvash
        sah: 'Саха тыла', // Sakha
        os: 'Ирон', // Ossetian
        ce: 'Нохчийн', // Chechen
        av: 'Авар', // Avar
        krc: 'Къарачай-Малкъар', // Karachay-Balkar
        ady: 'Адыгэбзэ', // Adyghe
        kab: 'Taqbaylit', // Kabyle
        ber: 'ⵜⴰⵎⴰⵣⵉⵖⵜ', // Berber
        gn: "Avañe'ẽ", // Guarani
        qu: 'Runasimi', // Quechua
        ay: 'Aymar aru', // Aymara
        nah: 'Nāhuatl', // Nahuatl
        yi: 'ייִדיש', // Yiddish
        lad: 'Ladino', // Ladino
        jv: 'Basa Jawa', // Javanese
        su: 'Basa Sunda', // Sundanese
        ceb: 'Binisaya', // Cebuano
        ilo: 'Ilokano', // Ilocano
        war: 'Winaray', // Waray
        pam: 'Kapampangan', // Kapampangan
        bcl: 'Bikol', // Bikol
        mni: 'মৈতৈলোন্', // Manipuri
        kok: 'कोंकणी', // Konkani
        doi: 'डोगरी', // Dogri
        sat: 'ᱥᱟᱱᱛᱟᱲᱤ', // Santali
        mwr: 'मारवाड़ी', // Marwari
        dcc: 'دکنی', // Deccani
        bho: 'भोजपुरी', // Bhojpuri
        awa: 'अवधी', // Awadhi
        mag: 'मगही', // Magahi
        mai: 'मैथिली', // Maithili
        raj: 'राजस्थानी', // Rajasthani
        pnb: 'پنجابی', // Western Punjabi
        skr: 'سرائیکی', // Saraiki
        hnd: 'ہندکو', // Hindko
        bft: 'بلتی', // Balti
        khw: 'کھوار', // Khowar
        shd: 'شینا', // Shina
        bgn: 'رواجی', // Western Balochi
        bgc: 'बागड़ी', // Bagri
        bgq: 'बागड़ी', // Bagri
        bgp: 'बागड़ी', // Bagri
        bgr: 'बागड़ी', // Bagri
        bgs: 'बागड़ी', // Bagri
        bgt: 'बागड़ी', // Bagri
        bgu: 'बागड़ी', // Bagri
        bgv: 'बागड़ी', // Bagri
        bgw: 'बागड़ी', // Bagri
        bgx: 'बागड़ी', // Bagri
        bgy: 'बागड़ी', // Bagri
        bgz: 'बागड़ी'  // Bagri
    },

    // Translations
    translations: {
        en: {
            // Navigation
            'nav.dashboard': 'Dashboard',
            'nav.modules': 'Modules',
            'nav.logout': 'Logout',
            
            // Phases
            'phase.review': 'Phase 1: Review',
            'phase.review.desc': 'Upload and analyze HTML files',
            'phase.build': 'Phase 2: Build',
            'phase.build.desc': 'Convert and optimize code',
            'phase.publish': 'Phase 3: Publish',
            'phase.publish.desc': 'Final review and deployment',
            
            // Steps
            'step.upload': 'Upload Files & Prompt',
            'step.upload.desc': 'Upload HTML files and initial prompt',
            'step.prompt': 'View Original Prompt',
            'step.prompt.desc': 'Review the initial prompt',
            'step.analysis': 'Analyze HTML Structure',
            'step.analysis.desc': 'Review HTML structure and components',
            'step.suggestion': 'AI Prompt Suggestion',
            'step.suggestion.desc': 'Get AI suggestions for prompt improvement',
            'step.report': 'View Review Report',
            'step.report.desc': 'Review the analysis report',
            'step.score': 'Check Prompt Accuracy Score',
            'step.score.desc': 'Review prompt accuracy metrics',
            
            // Status
            'status.completed': 'Completed',
            'status.in-progress': 'In Progress',
            'status.pending': 'Pending',
            
            // Messages
            'msg.offline': 'You\'re Offline',
            'msg.offline.desc': 'Please check your internet connection and try again.',
            'msg.retry': 'Retry Connection',
            'msg.error': 'An error occurred. Please try again.',
            'msg.success': 'Operation completed successfully.',
            
            // Actions
            'action.view': 'View Details',
            'action.close': 'Close',
            'action.retry': 'Retry',
            'action.export': 'Export',
            'action.save': 'Save',
            'action.cancel': 'Cancel'
        },
        es: {
            // Navigation
            'nav.dashboard': 'Panel de Control',
            'nav.modules': 'Módulos',
            'nav.logout': 'Cerrar Sesión',
            
            // Phases
            'phase.review': 'Fase 1: Revisión',
            'phase.review.desc': 'Subir y analizar archivos HTML',
            'phase.build': 'Fase 2: Construcción',
            'phase.build.desc': 'Convertir y optimizar código',
            'phase.publish': 'Fase 3: Publicación',
            'phase.publish.desc': 'Revisión final y despliegue',
            
            // Steps
            'step.upload': 'Subir Archivos y Prompt',
            'step.upload.desc': 'Subir archivos HTML y prompt inicial',
            'step.prompt': 'Ver Prompt Original',
            'step.prompt.desc': 'Revisar el prompt inicial',
            'step.analysis': 'Analizar Estructura HTML',
            'step.analysis.desc': 'Revisar estructura y componentes HTML',
            'step.suggestion': 'Sugerencia de Prompt IA',
            'step.suggestion.desc': 'Obtener sugerencias de IA para mejorar el prompt',
            'step.report': 'Ver Informe de Revisión',
            'step.report.desc': 'Revisar el informe de análisis',
            'step.score': 'Verificar Puntuación de Precisión',
            'step.score.desc': 'Revisar métricas de precisión del prompt',
            
            // Status
            'status.completed': 'Completado',
            'status.in-progress': 'En Progreso',
            'status.pending': 'Pendiente',
            
            // Messages
            'msg.offline': 'Estás Desconectado',
            'msg.offline.desc': 'Por favor, verifica tu conexión a internet e inténtalo de nuevo.',
            'msg.retry': 'Reintentar Conexión',
            'msg.error': 'Ha ocurrido un error. Por favor, inténtalo de nuevo.',
            'msg.success': 'Operación completada con éxito.',
            
            // Actions
            'action.view': 'Ver Detalles',
            'action.close': 'Cerrar',
            'action.retry': 'Reintentar',
            'action.export': 'Exportar',
            'action.save': 'Guardar',
            'action.cancel': 'Cancelar'
        },
        fr: {
            // Navigation
            'nav.dashboard': 'Tableau de Bord',
            'nav.modules': 'Modules',
            'nav.logout': 'Déconnexion',
            
            // Phases
            'phase.review': 'Phase 1: Révision',
            'phase.review.desc': 'Télécharger et analyser les fichiers HTML',
            'phase.build': 'Phase 2: Construction',
            'phase.build.desc': 'Convertir et optimiser le code',
            'phase.publish': 'Phase 3: Publication',
            'phase.publish.desc': 'Révision finale et déploiement',
            
            // Steps
            'step.upload': 'Télécharger les Fichiers',
            'step.upload.desc': 'Télécharger les fichiers HTML et le prompt initial',
            'step.prompt': 'Voir le Prompt Original',
            'step.prompt.desc': 'Examiner le prompt initial',
            'step.analysis': 'Analyser la Structure HTML',
            'step.analysis.desc': 'Examiner la structure et les composants HTML',
            'step.suggestion': 'Suggestion de Prompt IA',
            'step.suggestion.desc': 'Obtenir des suggestions d\'IA pour améliorer le prompt',
            'step.report': 'Voir le Rapport de Révision',
            'step.report.desc': 'Examiner le rapport d\'analyse',
            'step.score': 'Vérifier le Score de Précision',
            'step.score.desc': 'Examiner les métriques de précision du prompt',
            
            // Status
            'status.completed': 'Terminé',
            'status.in-progress': 'En Cours',
            'status.pending': 'En Attente',
            
            // Messages
            'msg.offline': 'Vous êtes Hors Ligne',
            'msg.offline.desc': 'Veuillez vérifier votre connexion internet et réessayer.',
            'msg.retry': 'Réessayer la Connexion',
            'msg.error': 'Une erreur est survenue. Veuillez réessayer.',
            'msg.success': 'Opération terminée avec succès.',
            
            // Actions
            'action.view': 'Voir les Détails',
            'action.close': 'Fermer',
            'action.retry': 'Réessayer',
            'action.export': 'Exporter',
            'action.save': 'Enregistrer',
            'action.cancel': 'Annuler'
        },
        de: {
            // Navigation
            'nav.dashboard': 'Dashboard',
            'nav.modules': 'Module',
            'nav.logout': 'Abmelden',
            
            // Phases
            'phase.review': 'Phase 1: Überprüfung',
            'phase.review.desc': 'HTML-Dateien hochladen und analysieren',
            'phase.build': 'Phase 2: Aufbau',
            'phase.build.desc': 'Code konvertieren und optimieren',
            'phase.publish': 'Phase 3: Veröffentlichung',
            'phase.publish.desc': 'Endgültige Überprüfung und Bereitstellung',
            
            // Steps
            'step.upload': 'Dateien Hochladen',
            'step.upload.desc': 'HTML-Dateien und initialen Prompt hochladen',
            'step.prompt': 'Originalen Prompt Anzeigen',
            'step.prompt.desc': 'Initialen Prompt überprüfen',
            'step.analysis': 'HTML-Struktur Analysieren',
            'step.analysis.desc': 'HTML-Struktur und Komponenten überprüfen',
            'step.suggestion': 'KI-Prompt-Vorschlag',
            'step.suggestion.desc': 'KI-Vorschläge zur Prompt-Verbesserung erhalten',
            'step.report': 'Überprüfungsbericht Anzeigen',
            'step.report.desc': 'Analysebericht überprüfen',
            'step.score': 'Prompt-Genauigkeitswert Prüfen',
            'step.score.desc': 'Prompt-Genauigkeitsmetriken überprüfen',
            
            // Status
            'status.completed': 'Abgeschlossen',
            'status.in-progress': 'In Bearbeitung',
            'status.pending': 'Ausstehend',
            
            // Messages
            'msg.offline': 'Sie sind Offline',
            'msg.offline.desc': 'Bitte überprüfen Sie Ihre Internetverbindung und versuchen Sie es erneut.',
            'msg.retry': 'Verbindung Wiederholen',
            'msg.error': 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.',
            'msg.success': 'Vorgang erfolgreich abgeschlossen.',
            
            // Actions
            'action.view': 'Details Anzeigen',
            'action.close': 'Schließen',
            'action.retry': 'Wiederholen',
            'action.export': 'Exportieren',
            'action.save': 'Speichern',
            'action.cancel': 'Abbrechen'
        },
        zh: {
            // Navigation
            'nav.dashboard': '仪表板',
            'nav.modules': '模块',
            'nav.logout': '退出登录',
            
            // Phases
            'phase.review': '第一阶段：审查',
            'phase.review.desc': '上传和分析HTML文件',
            'phase.build': '第二阶段：构建',
            'phase.build.desc': '转换和优化代码',
            'phase.publish': '第三阶段：发布',
            'phase.publish.desc': '最终审查和部署',
            
            // Steps
            'step.upload': '上传文件',
            'step.upload.desc': '上传HTML文件和初始提示',
            'step.prompt': '查看原始提示',
            'step.prompt.desc': '审查初始提示',
            'step.analysis': '分析HTML结构',
            'step.analysis.desc': '审查HTML结构和组件',
            'step.suggestion': 'AI提示建议',
            'step.suggestion.desc': '获取AI提示改进建议',
            'step.report': '查看审查报告',
            'step.report.desc': '审查分析报告',
            'step.score': '检查提示准确度分数',
            'step.score.desc': '审查提示准确度指标',
            
            // Status
            'status.completed': '已完成',
            'status.in-progress': '进行中',
            'status.pending': '待处理',
            
            // Messages
            'msg.offline': '您已离线',
            'msg.offline.desc': '请检查您的网络连接并重试。',
            'msg.retry': '重试连接',
            'msg.error': '发生错误。请重试。',
            'msg.success': '操作成功完成。',
            
            // Actions
            'action.view': '查看详情',
            'action.close': '关闭',
            'action.retry': '重试',
            'action.export': '导出',
            'action.save': '保存',
            'action.cancel': '取消'
        },
        ja: {
            // Navigation
            'nav.dashboard': 'ダッシュボード',
            'nav.modules': 'モジュール',
            'nav.logout': 'ログアウト',
            
            // Phases
            'phase.review': 'フェーズ1：レビュー',
            'phase.review.desc': 'HTMLファイルのアップロードと分析',
            'phase.build': 'フェーズ2：ビルド',
            'phase.build.desc': 'コードの変換と最適化',
            'phase.publish': 'フェーズ3：公開',
            'phase.publish.desc': '最終レビューとデプロイ',
            
            // Steps
            'step.upload': 'ファイルアップロード',
            'step.upload.desc': 'HTMLファイルと初期プロンプトのアップロード',
            'step.prompt': '元のプロンプトを表示',
            'step.prompt.desc': '初期プロンプトのレビュー',
            'step.analysis': 'HTML構造の分析',
            'step.analysis.desc': 'HTML構造とコンポーネントのレビュー',
            'step.suggestion': 'AIプロンプト提案',
            'step.suggestion.desc': 'プロンプト改善のためのAI提案を取得',
            'step.report': 'レビューレポートの表示',
            'step.report.desc': '分析レポートのレビュー',
            'step.score': 'プロンプト精度スコアの確認',
            'step.score.desc': 'プロンプト精度メトリクスのレビュー',
            
            // Status
            'status.completed': '完了',
            'status.in-progress': '進行中',
            'status.pending': '保留中',
            
            // Messages
            'msg.offline': 'オフラインです',
            'msg.offline.desc': 'インターネット接続を確認して再試行してください。',
            'msg.retry': '再接続',
            'msg.error': 'エラーが発生しました。もう一度お試しください。',
            'msg.success': '操作が正常に完了しました。',
            
            // Actions
            'action.view': '詳細を表示',
            'action.close': '閉じる',
            'action.retry': '再試行',
            'action.export': 'エクスポート',
            'action.save': '保存',
            'action.cancel': 'キャンセル'
        }
    },

    // Initialize
    init() {
        // Load saved language preference
        const savedLang = localStorage.getItem('preferredLanguage');
        if (savedLang && this.languages[savedLang]) {
            this.currentLang = savedLang;
        } else {
            // Try to detect browser language
            const browserLang = navigator.language.split('-')[0];
            if (this.languages[browserLang]) {
                this.currentLang = browserLang;
            }
        }
        
        this.updateDocument();
    },

    // Change language
    setLanguage(lang) {
        if (this.languages[lang]) {
            this.currentLang = lang;
            localStorage.setItem('preferredLanguage', lang);
            this.updateDocument();
            return true;
        }
        return false;
    },

    // Get translation
    t(key) {
        const translation = this.translations[this.currentLang]?.[key];
        return translation || this.translations.en[key] || key;
    },

    // Update document with translations
    updateDocument() {
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            const translation = this.t(key);
            
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.placeholder = translation;
            } else {
                element.textContent = translation;
            }
        });

        // Update HTML lang attribute
        document.documentElement.lang = this.currentLang;

        // Set RTL for Arabic
        document.documentElement.dir = this.currentLang === 'ar' ? 'rtl' : 'ltr';

        // Dispatch language change event
        window.dispatchEvent(new CustomEvent('languageChanged', {
            detail: { language: this.currentLang }
        }));
    },

    // Format numbers according to locale
    formatNumber(number) {
        return new Intl.NumberFormat(this.currentLang).format(number);
    },

    // Format dates according to locale
    formatDate(date) {
        return new Intl.DateTimeFormat(this.currentLang, {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    },

    // Format currency according to locale
    formatCurrency(amount, currency = 'USD') {
        return new Intl.NumberFormat(this.currentLang, {
            style: 'currency',
            currency: currency
        }).format(amount);
    },

    // Get current language name
    getCurrentLanguageName() {
        return this.languages[this.currentLang] || 'English';
    },

    // Get all available languages
    getAvailableLanguages() {
        return Object.entries(this.languages).map(([code, name]) => ({
            code,
            name
        }));
    }
};

// Initialize internationalization
document.addEventListener('DOMContentLoaded', () => {
    I18n.init();
});

// Export for use in other files
window.I18n = I18n; 
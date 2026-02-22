import eslint from '@eslint/js';
import tseslint from 'typescript-eslint';
import pluginVue from 'eslint-plugin-vue';
import eslintConfigPrettier from 'eslint-config-prettier';

export default tseslint.config(
    eslint.configs.recommended,
    ...tseslint.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    {
        files: ['*.vue', '**/*.vue'],
        languageOptions: {
            parserOptions: {
                parser: tseslint.parser,
                extraFileExtensions: ['.vue'],
                sourceType: 'module',
            },
        },
        rules: {
            'vue/multi-word-component-names': 'off',
            'vue/require-default-prop': 'off',
        },
    },

    {
        ignores: [
            'vendor/**',
            'public/**',
            'bootstrap/ssr/**',
            'node_modules/**',
            'resources/js/ziggy.js'
        ],
    },

    eslintConfigPrettier
);

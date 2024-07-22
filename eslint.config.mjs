import globals from 'globals';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import js from '@eslint/js';
import { FlatCompat } from '@eslint/eslintrc';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const compat = new FlatCompat({
	baseDirectory: __dirname,
	recommendedConfig: js.configs.recommended,
	allConfig: js.configs.all,
});

export default [
	{
		ignores: ['**/dist/**/*', '**/vendor/**/*', '**/node_modules/**/*'],
	},
	...compat.extends(
		'plugin:@wordpress/eslint-plugin/custom',
		'plugin:@wordpress/eslint-plugin/es5',
		'plugin:@wordpress/eslint-plugin/esnext',
		'plugin:@wordpress/eslint-plugin/i18n',
		'plugin:@wordpress/eslint-plugin/jsdoc',
		'plugin:prettier/recommended'
	),
	{
		languageOptions: {
			globals: {
				...globals.browser,
				...globals.node,
			},

			ecmaVersion: 'latest',
			sourceType: 'module',
		},
	},
	{
		rules: {
			'@wordpress/no-unused-vars-before-return': 'off',
		},
	},
];

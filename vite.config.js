import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig(({ command, mode }) => {
	const env = loadEnv(mode, process.cwd(), '')
	return {
		plugins: [
			laravel({
				input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                    'resources/css/dropdown-menu.css',
                    'resources/js/tinymce.js',
				],
				refresh: true,
			}),
		],
		resolve: {
			alias: {
				'$': 'jQuery'
			},
		},
		server: {
			host: 	env.VITE_HOST,
			port: 	env.VITE_PORT,
			https: 	env.VITE_HTTPS,
		}
	}
});

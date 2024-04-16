{ pkgs }: {
	deps = [
   pkgs.sqlite
		pkgs.php80
        pkgs.php80Packages.composer
	];
}
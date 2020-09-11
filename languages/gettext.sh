# Change every instance of memberlite-shortcodes below to match your actual plugin slug
#---------------------------
# This script generates a new pmpro.pot file for use in translations.
# To generate a new memberlite-shortcodes.pot, cd to the main /memberlite-shortcodes/ directory,
# then execute `languages/gettext.sh` from the command line.
# then fix the header info (helps to have the old pmpro.pot open before running script above)
# then execute `cp languages/memberlite-shortcodes.pot languages/memberlite-shortcodes.po` to copy the .pot to .po
# then execute `msgfmt languages/memberlite-shortcodes.po --output-file languages/memberlite-shortcodes.mo` to generate the .mo
#---------------------------
echo "Updating memberlite-shortcodes.pot... "
xgettext -j -o languages/memberlite-shortcodes.pot \
--default-domain=memberlite-shortcodes \
--language=PHP \
--keyword=_ \
--keyword=__ \
--keyword=_e \
--keyword=_ex \
--keyword=_n \
--keyword=_x \
--sort-by-file \
--package-version=1.1 \
--msgid-bugs-address="info@paidmembershipspro.com" \
$(find . -name "*.php")
echo "Done!"
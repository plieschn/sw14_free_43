NAME=presentation
FINAL_NAME=sw_14_free_43
PICS_SVG=`ls images/*.svg`
PICS_PNG=`ls images/*.png`
PICS_JPG=`ls images/*.jpg`

all : latex

.PHONY:clean
clean :
	rm -f *.bbx *.bcf *.blg *.bbl *.cbx *.lof *.log *.lot *.toc *.dvi *.out *.bcf *.run.xml
	rm -f `ls *.pdf | grep -v 'logo.pdf' | grep -v 'kurz.pdf' | grep -v 'institutslogo.pdf' | grep -v 'beispiel.pdf' | grep -v 'README.pdf'`
	find -name '*~' -exec rm {} \;
	find -name '*.bak' -exec rm {} \;
	find -name '*.aux' -exec rm {} \;
	find -name '*.log' -exec rm {} \;


.PHONY:latex
latex : 
	pdflatex $(NAME).tex
#	biber $(NAME)
	pdflatex $(NAME).tex
	pdflatex $(NAME).tex
	cp $(NAME).pdf $(FINAL_NAME).pdf

.PHONY:images
images :
	for i in $(PICS_SVG); do inkscape -z $$i -A `echo $$i | sed 's/\(.*\.\)svg/\1pdf/'`; done
	for i in $(PICS_PNG); do convert $$i `echo $$i | sed 's/\(.*\.\)png/\1pdf/'`; done
	for i in $(PICS_JPG); do convert $$i `echo $$i | sed 's/\(.*\.\)jpg/\1pdf/'`; done

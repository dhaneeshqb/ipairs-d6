<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<xsl:template match="GlossaryTerm">
		<span class="glossary-name"><xsl:value-of select="TermName"/></span>
		<span class="glossary-pronunciation"><xsl:value-of select="TermPronunciation"/></span>
		
		<p class="glossary-definition"><xsl:value-of select="TermDefinition/DefinitionText" /></p>
	</xsl:template>
	
</xsl:stylesheet>
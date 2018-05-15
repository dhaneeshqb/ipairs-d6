<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<xsl:template match="Term">
		<div id="term-info">
			
		<h2><xsl:value-of select="PreferredName"/></h2>
		<div id="term-id"><xsl:value-of select="@id"/></div>
		<div id="legacy-id"><xsl:value-of select="@LegacyPDQID"/></div>
		
		<h3>Other Names:</h3>
		<ul>
		<xsl:for-each select="OtherName">
			<li class="othername">
			<div>Name: <xsl:value-of select="OtherTermName"/></div>
			<div>Type: <xsl:value-of select="OtherTermType"/></div>
			</li>
		</xsl:for-each>
		</ul>
		
		<h3>Description</h3>
		<div id="term-description"><xsl:value-of select="Definition/DefinitionText"/></div>
		
		<h3>Semantic Type</h3>
		<div id="term-semantic-type"><xsl:value-of select="SemanticType"/></div>
		
		<div id="term-dates">
			<p>First Published: <xsl:value-of select="DateFirstPublished"/></p>
			<p>Last Modified: <xsl:value-of select="DateLastModified"/></p>
		</div>
	
		</div>
	</xsl:template>
	
</xsl:stylesheet>
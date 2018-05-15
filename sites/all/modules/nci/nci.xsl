<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<xsl:template match="Term">
		<div id="term-info">
			
		<h2><xsl:value-of select="PreferredName"/></h2>
		<div id="term-id"><xsl:value-of select="@id"/></div>
		
		<h3>Other Names:</h3>
		<ul>
		<xsl:for-each select="OtherName">
			<li class="othername"><xsl:value-of select="OtherTermName"/></li>
		</xsl:for-each>
		</ul>
		
		<h3>Description</h3>
		<p id="term-description"><xsl:value-of select="Definition/DefinitionText"/></p>
		
		<h3>Semantic Type</h3>
		<div id="term-semantic-type"><xsl:value-of select="SemanticType"/></div>
		
		<div id="term-dates">
			<span class="term-label">First Published: </span><xsl:value-of select="DateFirstPublished"/><br/>
			<span class="term-label">Last Modified: </span><xsl:value-of select="DateLastModified"/>
		</div>
	
		</div>
	</xsl:template>
	
</xsl:stylesheet>
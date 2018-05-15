<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
	<xsl:template match="TermRef">
		<div><a href="content?termid={@ref}"><xsl:value-of select="."/></a></div>
	</xsl:template>
	
	<xsl:template match="GlossaryTermRef">
		<a href="glossary?glossaryid={@href}"><xsl:value-of select="."/></a>
	</xsl:template>
	
	<xsl:template match="SpecificDiagnosis">
		<div><a href="content?termid={@ref}"><xsl:value-of select="."/></a></div>
	</xsl:template>
	
	<xsl:template match="MediaLink">
		<div class="media-link">
			<img src="[site_url]/Media/{@ref}.jpg" width="780"/><br/>
			<div class="media-caption"><xsl:value-of select="Caption"/></div>
		</div>
	</xsl:template>
	
	<xsl:template match="Para">
		<p>
		<xsl:apply-templates/>
		<xsl:value-of select="."/>
		</p>
	</xsl:template>
	
	<xsl:template match="ReferenceSection">
		<ul class="summary-references">
			<xsl:for-each select="Citation">
				<li><xsl:value-of select="."/></li>
			</xsl:for-each>
		</ul>
	</xsl:template>

	
	<xsl:template match="Summary">
		
		<h2 class="summary-title"><xsl:value-of select="SummaryTitle"/></h2>
		
		<div id="summary-links">
			<ul>
				<xsl:for-each select="SummarySection">
					<li><a href="#Section{@id}"><xsl:value-of select="Title"/></a></li>
				</xsl:for-each>
			</ul>
		</div>
		
		<div id="summary-info">
			
			<div id="summary-sections">
			<xsl:for-each select="SummarySection">
				<div class="summary-section">
					<h3 id="Section{@id}" class="summary-section-title"><xsl:value-of select="Title"/></h3>
					
					<xsl:for-each select="SummarySection">
						<xsl:if test="Title"><h3 id="Section{@id}"><xsl:value-of select="Title"/></h3></xsl:if>
						<p><xsl:apply-templates select="Para"/></p>
						<xsl:if test="ItemizedList">
							<ul>
							<xsl:for-each select="ItemizedList/ListItem">
								<li><xsl:value-of select="."/></li>
							</xsl:for-each>
							</ul>
						</xsl:if>
						<xsl:if test="MediaLink">
							<xsl:apply-templates />
						</xsl:if>
					</xsl:for-each>
					
					<xsl:for-each select="Para">
						<p><xsl:value-of select="."/></p>
					</xsl:for-each>
				</div>
				<xsl:if test="ReferenceSection"><h4>References:</h4>
					<xsl:apply-templates select="ReferenceSection"/>
				</xsl:if>
			</xsl:for-each>
			</div>
		</div>
	</xsl:template>
	
</xsl:stylesheet>
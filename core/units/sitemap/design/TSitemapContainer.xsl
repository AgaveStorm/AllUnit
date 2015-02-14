<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TSitemapContainer">
        <h1>Sitemap</h1>
        <div>
            <xsl:for-each select="pages/item">
                <h3>
                <a href="{//siteurl}/{slug}">
                    <xsl:value-of select="title"/>
                    <small>
                       &#160; (<xsl:value-of select="slug"/>)
                    </small>
                </a>
                </h3>
            </xsl:for-each>
        </div>
    </xsl:template>
</xsl:stylesheet>

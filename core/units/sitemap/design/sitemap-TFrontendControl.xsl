<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="sitemap-TFrontendControl">
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <xsl:for-each select="pages/item">
                    <url>
                        <loc>
                            <xsl:value-of select="//siteurl"/>/<xsl:value-of select="slug"/>
                        </loc>
                    </url>
            </xsl:for-each>
        </urlset>
    </xsl:template>
</xsl:stylesheet>
